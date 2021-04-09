import numpy as np
import time


class NaiveAnon:
    """
    Arrondit au n ème nombre après la virgule des données passées en entrée
    """
    def __init__(self, data: np.array, n_decimal: int):
        """
        Méthode d'initialisation de la classe.
        :param data: Les données à regrouper
        :param n_decimal: Nombre de chiffres après la virgule
        """
        # Les données à regrouper
        self.data = data

        # Nombre de chiffres après la virugle
        self.n_decimal = n_decimal

    def anon_data(self) -> None:
        """
        Anonymise les données en arrondissant au n ème nombre après la virgule
        :return: None
        """
        time_start = time.time()
        self.data = np.around(self.data, self.n_decimal)
        print("Done in", time.time() - time_start, "sec")


data = np.load("privamov-gps-final-data.npz")
idx = data['index']
values = data['values']
del data


anonymizer = NaiveAnon(values[:, -2:], 2)
anonymizer.anon_data()








