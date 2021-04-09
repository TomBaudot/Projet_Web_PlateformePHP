import numpy as np
import csv


def change_form_data(row: list) -> list:
    """
    Change la forme des données
    :param row: Une ligne de données
    :return: Une liste avec les données dans une forme utilisable
    """

    # On sépare chaque élément de la date dans une liste
    date = row[1].split()

    date = [data for data in date[0].split('-')] + [data for data in date[1].split(':')]

    sec_ms = date[-1].split(".")

    if len(sec_ms) < 2:
        sec_ms += [0]

    # On change l'id de la donnée en fct du mois et de l'ancien id

    row = [row[0]] + date[:-1] + sec_ms + row[2:]

    return [float(ele) for ele in row]


def load_data(file_name: str, n_lines: int) -> list:
    """
    Charge les n premières lignes d'un fichier .csv dont le nom est donné en paramètre
    :param file_name: Le nom du fichier csv
    :param n_lines: Le nombre de lignes à charger. Si on veut charger tout le fichier, mettre -1.
    :return: Une liste contenant les lignes chargées du fichier csv (ces lignes sont sous la forme de liste également)
    """
    limit = n_lines if n_lines >= 0 else float('inf')

    with open(file_name, 'r', encoding='utf-8') as f:
        csv_file = csv.reader(f, delimiter='\t')

        data = []

        for ind, ele in enumerate(csv_file):
            try:
                if ind > limit:
                    break

                data.append(change_form_data(ele))

            except MemoryError:
                exit(0)

        return data


def create_first_npz_file(filename: str, data: list) -> None:
    """
    Créer un fichier npz les données en param
    :param filename: Le nom du fichier à créer
    :param data: Les données à sauvegarder
    :return: None
    """

    np.savez(filename, data=np.array(data))
