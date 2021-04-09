import re
import datetime


def apply_anonymization(data_list: list, ind_date: int, f_file_content: dict) -> None:
    """
    Applique l'anonymisation sur les données passées en param
    :param data_list: Liste de données
    :param ind_date: Index de la date dans chaque ligne
    :param f_file_content: Le contenu du fichier F sous la forme d'un dictionnaire
    :return: None
    """

    for l in data_list:
        # On sépare chaque élément de la date dans une liste
        date = l[ind_date].split()

        date = [data for data in date[0].split('-')] + [data for data in date[1].split(':')]

        # On change l'id de la donnée en fct du mois et de l'ancien id

        l[0] = f_file_content[l[0]][date[1]][0]


def basic_anon(data_list: list, ind_date: int) -> dict:
    """
    Algo basique d'anon
    :param data_list: Liste de données
    :param ind_date: Index de la date dans chaque ligne
    :return: None
    """

    new_id = 0

    user_2_date_2_new_id = {}

    for l in data_list:

        # On sépare chaque élément de la date dans une liste
        date = l[ind_date].split()

        date = [data for data in date[0].split('-')] + [data for data in date[1].split(':')]

        if l[0] not in user_2_date_2_new_id:

            user_2_date_2_new_id[l[0]] = {date[1]: [str(new_id)]}

            new_id += 1

        elif date[1] not in user_2_date_2_new_id[l[0]]:

            user_2_date_2_new_id[l[0]][date[1]] = [str(new_id)]

            new_id += 1

    return user_2_date_2_new_id


def generate_relationship_between_data(data_ref: list, data_sub: list) -> dict:
    """
    Génere le contenu d'un fichier f à partir de 2 listes de données
    :param data_ref: Les données de référence/source
    :param data_sub: Les nouvelles données
    :return: Un dictionnaire faisant le lien entre les anciens id et les nouveaux id
    """
    try:
        ind_date = next(i for i in range(len(data_ref[0]))
                        if bool(re.match(
            "^([0-9]{4})-([0-1][0-9])-([0-3][0-9])\s([0-1][0-9]|[2][0-3]):([0-5][0-9]):([0-5][0-9])", data_ref[0][i])))

    except StopIteration:
        ind_date = 1

    assert len(data_ref) == len(data_sub), "Les fichiers n'ont pas le même nombre de lignes"

    user_2_date_2_new_id = {}

    for ind, row in enumerate(data_ref):

        if data_sub[ind][0] != 'DEL':

            # On sépare chaque élément de la date dans une liste
            date = row[ind_date].split()

            ymd = [int(data) for data in date[0].split('-')]

            isoweek = str(ymd[0]) + "-" + str(datetime.date(*ymd).isocalendar()[1])

            if row[0] not in user_2_date_2_new_id:

                user_2_date_2_new_id[row[0]] = {isoweek: [data_sub[ind][0]]}

            elif isoweek not in user_2_date_2_new_id[row[0]]:

                user_2_date_2_new_id[row[0]][isoweek] = [data_sub[ind][0]]

            elif data_sub[ind][0] not in user_2_date_2_new_id[row[0]][isoweek]:

                exit(0)
                #user_2_date_2_new_id[row[0]][isoweek].append(data_sub[ind][0])

    return user_2_date_2_new_id
