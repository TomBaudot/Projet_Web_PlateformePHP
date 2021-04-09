import random
import csv
import pickle
import anonymization
import json


def load_data(file_name: str) -> list:
    """
    Charge les données d'un fichier .csv dont le nom est donné en paramètre
    :param file_name: Le nom du fichier csv
    :return: Une liste contenant chaque ligne du fichier csv (ces lignes sont sous la forme de liste également)
    """
    try:
        with open(file_name, 'r', encoding='utf-8') as f:
            csv_file = csv.reader(f, delimiter='\t')

            return [row for row in csv_file]

    except FileNotFoundError:
        return []


def create_shuffled_file(new_file_name: str, data_list: list) -> dict:
    """
    Créer un nouveau fichier .csv avec les données passées en paramètre qui sont mélangées
    :param new_file_name: Le nom du nouveau fichier csv
    :param data_list: Les données à écrire sur le fichier
    :return: Un dictionnaire faisant la correspondance entre les index de la liste passée en paramètre et l'ordre
    des données dans lequel elles sont écrites dans le nouveau fichier
    """

    new_ind_2_old_ind = {}

    L = len(data_list)

    if not L:
        return new_ind_2_old_ind

    with open(new_file_name, 'w', encoding='utf-8', newline='') as f:
        writer = csv.writer(f, delimiter='\t')

        new_row_order = [*range(L)]

        random.shuffle(new_row_order)

        for i in range(L):
            new_ind_2_old_ind[i] = new_row_order[i]

            writer.writerow(data_list[new_row_order[i]])

    return new_ind_2_old_ind


def save_relationship_between_index(filename: str, old_ind_2_new_ind: dict) -> None:
    """
    Sauvegarde dans un fichier les relations entre index
    :param filename: Le nom du fichier dans lequel sauvegarder les relations entre les index
    :param old_ind_2_new_ind: La relation entre les anciens index et les nouveaux
    :return: None
    """

    with open(filename + '.pkl', 'wb') as f:
        pickle.dump(old_ind_2_new_ind, f, pickle.HIGHEST_PROTOCOL)


def load_relationship_between_index(filename: str) -> dict:
    """
    Charge les relations entre les index contenues dans un fichier .pkl
    :param filename: Le nom du fichier où sont sauvegardées les relations
    :return: Un dictionnaire
    """
    try:
        with open(filename + '.pkl', 'rb') as f:
            return pickle.load(f)
    except FileNotFoundError:
        return {}


def unshuffle_file(filename: str, data_list: list, new_ind_2_old_ind: dict) -> None:
    """
    Remet un fichier dans l'état dans lequel il était avant d'être mélangé.
    :param filename: Nom du fichier à créer qui sera similaire au fichier d'origine
    :param data_list: Liste contenant les lignes du fichier mélangé
    :param new_ind_2_old_ind: La relation entre les anciens index et les nouveaux
    :return: None
    """

    old_ind_2_new_ind = {value: key for key, value in new_ind_2_old_ind.items()}

    L = len(data_list)

    if not L or not old_ind_2_new_ind:
        return None

    with open(filename, 'w', encoding='utf-8', newline='') as f:
        writer = csv.writer(f, delimiter='\t')

        for i in range(L):
            writer.writerow(data_list[old_ind_2_new_ind[i]])


def create_unshuffled_file(s_file_path: str, l_file_path: str, s_file_name: str, l_file_name: str, new_file: str) -> None:
    """

    :param s_file_path: Le chemin jusqu'au répertoire dans lequel on veut sauvegarder le fichier shuffled
    :param l_file_path: Le chemin jusqu'au répertoire dans lequel on veut sauvegarder le fichier de correspondance entre
                        le fichier d'origine et le fichier shuffled

    :param s_file_name: Le nom du fichier shuffled (ne pas mettre S_ devant)
    :param l_file_name: Le nom du fichier de correspondance entre le fichier d'origine et le fichier shuffled
    :param new_file: Le nom du nouveau fichier à créer
    :return: None
    """
    data = load_data(s_file_path + 'S_' + s_file_name + '.csv')

    index_relationship = load_relationship_between_index(l_file_path + 'L_' + l_file_name)

    unshuffle_file(new_file + '.csv', data, index_relationship)


def load_original_data(s_file_path: str, l_file_path: str, s_file_name: str,
                       l_file_name: str) -> list:
    """
    Charge les données du fichier shuffled en paramètre et les renvoie dans l'ordre original
    :param s_file_path: Le chemin jusqu'au répertoire dans lequel on veut sauvegarder le fichier shuffled
    :param l_file_path: Le chemin jusqu'au répertoire dans lequel on veut sauvegarder le fichier de correspondance entre
                        le fichier d'origine et le fichier shuffled

    :param s_file_name: Le nom du fichier shuffled (ne pas mettre S_ devant)
    :param l_file_name: Le nom du fichier de correspondance entre le fichier d'origine et le fichier shuffled
    :return: Les données originales dans le bon ordre
    """

    shuffled_data = load_data(s_file_path + 'S_' + s_file_name + '.csv')

    new_ind_2_old_ind = load_relationship_between_index(l_file_path + 'L_' + l_file_name)

    old_ind_2_new_ind = {value: key for key, value in new_ind_2_old_ind.items()}

    return [shuffled_data[old_ind_2_new_ind[i]] for i in range(len(shuffled_data))]


def store_data_file(src_path: str, s_file_path: str, l_file_path: str, src_name: str, s_file_name: str,
                    l_file_name: str) -> None:
    """
    Prend un fichier, mélange ses données et enregistre les données mélangées + la relation entre le fichier d'origine
    et le fichier shuffled
    :param src_path: Le chemin jusqu'au répertoire dans lequel est contenu le fichier d'origine
    :param s_file_path: Le chemin jusqu'au répertoire dans lequel on veut sauvegarder le fichier shuffled
    :param l_file_path: Le chemin jusqu'au répertoire dans lequel on veut sauvegarder le fichier de correspondance entre
                        le fichier d'origine et le fichier shuffled

    :param src_name: Le nom du fichier d'origine
    :param s_file_name: Le nom du fichier shuffled (ne pas mettre S_ devant)
    :param l_file_name: Le nom du fichier de correspondance entre le fichier d'origine et le fichier shuffled
    :return: None
    """
    print("go store")
    data = load_data(src_path + src_name)

    print("ok load")
    index_relationship = create_shuffled_file(s_file_path + 'S_' + s_file_name + '.csv', data)

    print("ok create")
    save_relationship_between_index(l_file_path + 'L_' + l_file_name, index_relationship)

    print("Ok fichiers L")


def dict2json(filename: str, dic: dict):
    """
    Sauvegarde un dictionnaire au format json
    :param filename: Le nom du fichier .json à créer
    :param dic: Le dictionnaire à créer
    :return: None
    """
    with open(filename +'.json', 'w') as file:
        json.dump(dic, file)


def load_dict_from_json(filename: str) -> dict:
    with open(filename + '.json', 'r') as file:
        return json.load(file)


def generate_F_files_from_subfile(ref_path: str, sub_path: str, f_file_path: str, ref_name: str, sub_name: str, f_file_name: str) -> None:
    """
    Génère un fichier F à partir d'un fichier de référence et un nouveau fichier
    :param ref_path: Le chemin jusqu'au répertoire où se situe le fichier de référence
    :param sub_path: Le chemin jusqu'au répertoire où se situe le nouveau fichier
    :param f_file_path: Le chemin du répertoire dans lequel créer le fichier F
    :param ref_name: Le nom du fichier de référence
    :param sub_name: Le nom du fichier du nouveau fichier
    :param f_file_name: Le nom du fichier F à créer
    :return: None
    """

    data_ref = load_data(ref_path + ref_name)

    data_sub = load_data(sub_path + sub_name)

    f_file_content = anonymization.generate_relationship_between_data(data_ref, data_sub)

    dict2json(f_file_path + 'F_' + f_file_name, f_file_content)
