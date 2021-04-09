import numpy as np
import matplotlib.pyplot as plt
import time
import csv

DEL_VALUE = -1


def euclidean_distance(c1: np.array, c2: np.array):
    """
    Méthode calculant la distance euclidienne entre 2 coordonnées
    :param c1: Premières coordonnées
    :param c2: Deuxièmes coordonnées
    :return: La distance euclidienne entre les deux coordonnées
    """
    return np.linalg.norm(c1 - c2, axis=1)


def save_data(file_name: str, data_list) -> None:
    """
    Sauvegarde les données dans le fichier passé en param
    :param file_name: Le nom du fichier à créer
    :param data_list: Les données à sauvegarder
    :return: None
    """
    with open(file_name, 'w', encoding='utf-8', newline='') as f:

        writer = csv.writer(f, delimiter='\t')

        writer.writerows(data_list)


def create_final_list(data) -> list:
    """
    Remet en forme les données
    :param data: Les données sous la forme d'une liste
    :return: None
    """

    final_list = []

    for row in data:

        id = row[0] if row[0] != DEL_VALUE else 'DEL'

        new_row = [id] + ['{:02d}-{:02d}-{:02d} {:02d}:{:02d}:{:02d}.{}'.format(int(row[1]), int(row[2]), int(row[3]), int(row[4]), int(row[5]), int(row[6]), int(row[7]))] + [row[8], row[9]]

        final_list.append(new_row)

    return final_list


class NaiveClustering:
    """
    Regroupe des données dans des clusters en fonction de la distance entre chaque point
    """
    def __init__(self, data: np.array, radius: float, index: np.array):
        """
        Méthode d'initialisation de la classe.
        :param data: Les données à regrouper
        :param radius: le rayon dans lequel on considére que deux points appartiennent au même cluster
        """
        # Les données à regrouper
        self.data = data

        # Index à anonymiser
        self.index = index

        # Le rayon de regroupement
        self.radius = radius

        # Label pour chaque ligne des données indiquant à quel cluster elle appartient
        self.labels = None

    def belong_2_same_cluster(self, c1: np.array, c2: np.array):
        """
        Regarde si c1 peut appartenir à un cluster se trouvant dans c2
        :param c1: Premières coordonnées (une ligne)
        :param c2: Deuxièmes coordonnées (>= 1 ligne)
        :return: Retourne l'index d'une ligne de coordonnées qui appartient au même cluster que c1 si elle existe.
        Sinon renvoie une np.array vide
        """

        return np.where((euclidean_distance(np.full(c2.shape, c1), c2) < self.radius) == 1)[0]

    def print_progress(self, idx: int, total_size: int, **kwargs):
        """
        Affiche le progrès de la création des clusters
        :param idx: L'index courant de la boucle principale
        :param total_size: Le nombre de données à parcourir
        :param kwargs: Des info supplémentaires à afficher
        :return: None
        """
        pos_bracket = int(idx * 30 / total_size)

        string = "\r{}/{}  ".format(idx, total_size)
        string += "[" + ''.join('=' for _ in range(pos_bracket - 1)) + ''.join('>' for _ in range(pos_bracket > 0)) + ''.join('.' for _ in range(30 - pos_bracket)) + '] '
        string += ' '.join("{} = {}  ".format(str(key), str(val)) for key, val in kwargs.items())

        print(string, end='', flush=True)

    def create_clusters(self, print_progress=False) -> None:
        """
        Créer les clusters à partir des données de l'attribut data
        :param print_progress: Booléen pour indiquer si on veut afficher le progrès de notre boucle principale
        :return: None
        """

        # Une liste associant à chaque ligne le label correspondant
        labels = []

        # Coordonnées des clusters
        np_coords_clusters = np.array(self.data[0, :]).reshape((1, 2))

        # Nombre de lignes dans les données
        m = self.data.shape[0]

        # Intervalle à laquelle afficher le progrès
        interval = m // 100 if m > 100 else 1

        for i in range(m):

            # On obtient l'index du cluster auquel la ligne i des données peut appartenir
            cur_idx_clusters = self.belong_2_same_cluster(self.data[i, :], np_coords_clusters)

            # Si aucun cluster ne peut contenir la ligne i
            if not cur_idx_clusters.size:

                # On crée un nouveau cluster
                cur_idx_clusters = [np_coords_clusters.shape[0]]
                np_coords_clusters = np.vstack((np_coords_clusters, self.data[i, :]))

            # On enregistre le cluster associé à la ligne i
            labels.append(cur_idx_clusters[0])

            if print_progress and (i % interval) == 0:
                self.print_progress(i, m, n_clusters=np_coords_clusters.shape[0])

        self.labels = np.array(labels)
        if print_progress:
            self.print_progress(m, m)
            print()

    def plot_data(self):
        """
        Affiche les données en fct de leur cluster
        :return: None
        """

        if type(self.labels) is np.ndarray:

            fig = plt.figure()
            ax = fig.add_subplot(111)

            scatter = ax.scatter(self.data[:, 0], self.data[:, 1], c=self.labels, s=50)

            ax.set_xlabel('Latitude')
            ax.set_ylabel('Longitude')

            plt.colorbar(scatter)
            fig.show()
            plt.show()

    def anon_data(self) -> None:
        """
        Anonymise les données en faisant les moyennes des coordonnées qui appartiennent au même cluster
        :return: None
        """

        if type(self.labels) is np.ndarray:

            time_start = time.time()

            s_labels = set(self.labels.tolist())

            for l in s_labels:

                pts_assigned_2_l = (l == self.labels)

                self.data[pts_assigned_2_l, :] = np.full(self.data[pts_assigned_2_l, :].shape,
                                                         np.sum(self.data[pts_assigned_2_l, :], axis=0) /
                                                         self.data[pts_assigned_2_l, :].shape[0])

            print("Done in", time.time() - time_start, "sec")

    def anon_index(self, full_data):
        """
        Anonymise les indices
        :return: None
        """

        lower = 100000

        higher = 999999

        # Les IDs anonymisés utilisés
        new_idx_used = set()

        # Nombre de lignes
        m = self.index.shape[0]

        # Un dictionnaire reliant les anciens couples ID/Date au nombre de fois qu'ils apparaissent dans les données
        old_couples_count = np.unique(np.hstack((self.index.reshape((m, 1)), full_data[:, 1].reshape((m, 1)))), return_counts=True, axis=0)

        # Le plus petit nombre d'occurrences dans le dictionnaire au dessus
        max_occ_per_couple = old_couples_count[1].min()

        # Un id anonymisé
        new_id = np.random.randint(lower, higher, 1)[0]

        # Pour chaque couple existant dans les données
        for couple in old_couples_count[0]:

            # On sélectionne les cases qui sont égales à ce couple
            idx_assigned_to_couple = np.logical_and(self.index == couple[0], full_data[:, 1] == couple[1])

            # On récupère l'index de ces cases
            pos_points = np.nonzero(idx_assigned_to_couple)[0]

            # On mélange les index
            np.random.shuffle(pos_points)

            # Tant que notre id anonymisé existe déjà
            while new_id in new_idx_used:

                # On prend un nouvel id
                new_id = np.random.randint(lower, higher, 1)[0]

            # On ajoute le nouvel id à la liste de ceux déjà utilisés
            new_idx_used.add(new_id)

            # On remplace max_occ_per_couple cases par le nouvel id
            self.index[pos_points[:max_occ_per_couple]] = new_id

            # On met DEL sur les autres
            self.index[pos_points[max_occ_per_couple:]] = DEL_VALUE


# À commenter si on a pas de fichier à tester

c1 = np.array([3.6890416673406046, 43.409594009148684]).reshape((1, 2))  # Coord GPS 1
c2 = np.array([3.68737333333333, 43.4094833333333])  # Coord GPS2
radius = np.linalg.norm(c1 - c2)
print("Distance used :", radius)


data = np.load("privamov-gps-final-data.npz")
idx = data['index'][:1000000]
values = data['values'][:1000000, :]
del data

print("Début training")
cluster = NaiveClustering(values[:, -2:], radius, idx)
start_time = time.time()
cluster.create_clusters(print_progress=True)
print("Done in", time.time() - start_time, "sec")
cluster.plot_data()
cluster.anon_data()
cluster.plot_data()
cluster.anon_index(values)

final_data = np.hstack((idx.reshape((idx.shape[0], 1)), values))
#
# save_data("anon_data.csv", create_final_list(final_data.tolist()))


