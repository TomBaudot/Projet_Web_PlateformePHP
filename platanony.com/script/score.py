import numpy as np
import database
import csv_file_handler
import os
from datetime import date


def compute_accuracy_v1(f_file_content_ref: dict, f_file_content_sub: dict) -> float:
    """
    Calcule la précision de la soumission d'un fichier F
    :param f_file_content_ref: Le contenu du fichier F original
    :param f_file_content_sub: Le contenu du fichier F soumis
    :return: Le pourcentage de réponses justes
    """

    # Liste pour stocker les résultats de la comparaison
    comparison = []

    # Nombre de comparaisons effectuées
    lenght = 0

    for id in f_file_content_ref:

        for date in f_file_content_ref[id]:

            if id in f_file_content_sub and date in f_file_content_sub[id]:
                comparison.append(
                    [(np.array(f_file_content_ref[id][date]) == np.array(f_file_content_sub[id][date])).astype(int).sum()])

                lenght += len(f_file_content_sub[id][date])

            else:

                lenght += 1

    return np.sum(np.array(comparison)) / lenght


def compute_accuracy_v2(f_file_content_ref: dict, f_file_content_sub: dict) -> float:
    """
    Calcule la précision de la soumission d'un fichier F
    :param f_file_content_ref: Le contenu du fichier F original
    :param f_file_content_sub: Le contenu du fichier F soumis
    :return: Le pourcentage de réponses justes
    """

    # Liste pour stocker les résultats de la comparaison
    comparison = []

    # Nombre de comparaisons effectuées
    lenght = 0

    for id in f_file_content_ref:

        for date in f_file_content_ref[id]:

            if id in f_file_content_sub and date in f_file_content_sub[id]:

                tmp = np.where(f_file_content_ref[id][date] == np.array(f_file_content_sub[id][date]))

                if tmp[0].size:

                    comparison.append(len(f_file_content_sub[id][date]) - tmp[0][0])

                else:
                    comparison.append(0)

                lenght += len(f_file_content_sub[id][date])

            else:

                lenght += 1

    return np.sum(np.array(comparison)) / lenght


def compute_accuracy_v3(f_file_content_ref: dict, f_file_content_sub: dict) -> float:
    """
    Calcule la précision de la soumission d'un fichier F
    :param f_file_content_ref: Le contenu du fichier F original
    :param f_file_content_sub: Le contenu du fichier F soumis
    :return: Le pourcentage de réponses justes
    """

    max_idx = 1

    # Liste pour stocker les résultats de la comparaison
    comparison = []

    # Nombre de comparaisons effectuées
    lenght = 0

    for id in f_file_content_ref:

        for date in f_file_content_ref[id]:

            if id in f_file_content_sub and date in f_file_content_sub[id]:


                tmp = np.where(f_file_content_ref[id][date] == np.array(f_file_content_sub[id][date]))


                if tmp[0].size:

                    l = len(f_file_content_sub[id][date])

                    score = l if tmp[0][0] <= max_idx else l - tmp[0][0] + max_idx

                    comparison.append(score)

                else:
                    comparison.append(0)

                lenght += len(f_file_content_sub[id][date])

            else:

                lenght += 1

    return np.sum(np.array(comparison)) / lenght


def compute_accuracy_v4(f_file_content_ref: dict, f_file_content_sub: dict) -> float:
    """
    Calcule la précision de la soumission d'un fichier F
    :param f_file_content_ref: Le contenu du fichier F original
    :param f_file_content_sub: Le contenu du fichier F soumis
    :return: Le pourcentage de réponses justes
    """

    # Liste pour stocker les résultats de la comparaison
    comparison = []

    # Nombre de comparaisons effectuées
    lenght = 0

    for id in f_file_content_ref:

        for date in f_file_content_ref[id]:

            if id in f_file_content_sub and date in f_file_content_sub[id]:
                score = (np.array(f_file_content_ref[id][date]) == np.array(f_file_content_sub[id][date])).astype(
                        int).sum() / len(f_file_content_sub[id])

                comparison.append(score)

                lenght += 1

            else:

                lenght += 1

    return np.sum(np.array(comparison)) / lenght

def write_log(file, log):

    today = date.today().strftime("%d/%m/%Y %H:%M:%S")

    f = open(file, "a")

    f.write('['+ today + ']' + log + '\n')

    f.close()


def utility_basic(source, file, coeff_coordonate):
    """
    Donne un score d'utilité basique, voir document utilité_basique
    :param source: le fichier non anonymisé
    :param file: le fichier anonymisé
    :coeff_coordonate: de l'ordre des puissances de 10, indique l'importance d'un petit ecart pour les coordonnées
    :return score d'utilité entre 0 et 1
    """
    realFile = csv_file_handler.load_data(source)
    fileAnony = csv_file_handler.load_data(file)

    if len(realFile) != len(fileAnony):
        write_log("log_admin", "delete file: " + file +" because it doesn't have the same lenght as the source file")
        try:
            os.remove(file)
        except FileNotFoundError:
            pass
        return -1

    utilite = list() #contiendra l'utilité de chaque entree pour faire le calcul final

    length = 0

    for i in range(len(realFile)):
        if fileAnony[i][0] != 'DEL':
            length += 1
            utiliteEntree = [0,0,0,0,0]

            #Uamj
            dateAnon = fileAnony[i][1].split()[0].split("-")
            dateReal = realFile[i][1].split()[0].split("-")

            ecartRelatif = [(abs(int(dateReal[k]) - int(dateAnon[k])) / int(dateReal[k])) for k in range(3)]
            utiliteEntree[1] = (1 / 396) * ecartRelatif[0] * 365 + ecartRelatif[1] * 30 + ecartRelatif[2]

            #Utemps
            tempsAnon = fileAnony[i][1].split()[1].split(":")
            tempsReal = realFile[i][1].split()[1].split(":")

            secondesReal = int(tempsReal[0]) * 3600 + int(tempsReal[1]) * 60 + float(tempsReal[2])
            secondesAnon = int(tempsAnon[0]) * 3600 + int(tempsAnon[1]) * 60 + float(tempsAnon[2])

            if secondesReal < 1e-8:
                utiliteEntree[2] = 0 if secondesReal == secondesAnon else 1
            else:
                utiliteEntree[2] = ((abs(secondesReal - secondesAnon)) / secondesReal)

            #Ucoord
            utiliteEntree[3] = ((abs(float(realFile[i][2]) - float(fileAnony[i][2])) / float(realFile[i][2])))
            utiliteEntree[4] = ((abs(float(realFile[i][3]) - float(fileAnony[i][3])) / float(realFile[i][3])))

            #Ui
            somme = utiliteEntree[0]+utiliteEntree[1]+utiliteEntree[2]+coeff_coordonate*(utiliteEntree[3]+utiliteEntree[4])
            utilite.append(1/(1 + somme))

    score = ((1/length)*(sum(utilite))) if ((1/length)*(sum(utilite))) < 1 else 1

    if score < 0 :
        write_log("log_admin", "delete file: " + file +" because it doesn't respect the format")
        os.remove(file)

    return score


def change_database_utility(id_submission: int, source: str, file: str, coeff_coordonate: int) -> None:
    """
    Calcule et modifie le score d'utilité dans la BDD
    :param id_submission: Un id de soumission
    :param source: le fichier non anonymisé
    :param file: le fichier anonymisé
    :param coeff_coordonate: de l'ordre des puissances de 10, indique l'importance d'un petit ecart pour les coordonnées
    :return: None
    """

    db = database.Database()

    score_utility = utility_basic(source, file, int(coeff_coordonate))

    if score_utility < 0:
        db.remove_submission(int(id_submission))

    else :
        db.modify_utility(int(id_submission), score_utility)

        db.init_defense_submission(int(id_submission), score_utility)

        db.modify_score_defense_on_team_table(id_submission)


def change_database_attack(id_attack: int, submission_f_file: str, attack__f_file: str) -> None:
    """
    Calcule et modifie le score d'attaque dans la BDD (dans la table team et attack) ainsi que le score défense
    de la team attaquée
    :param id_attack: L'ID de l'attaque
    :param submission_f_file: Le chemin absolu vers le fichier F de la soumission
    :param attack__f_file: Le chemin absolu vers le fichier F de l'attaque
    :return: None
    """

    db = database.Database()

    sub_f_file_content = csv_file_handler.load_dict_from_json(submission_f_file)

    attack_f_file_content = csv_file_handler.load_dict_from_json(attack__f_file)

    score_attack = compute_accuracy_v2(sub_f_file_content, attack_f_file_content)

    db.modify_attack_score(int(id_attack), score_attack)

    id_sub = db.get_id_submission_from_attack(int(id_attack))

    db.update_defense_submission(id_sub)

    db.modify_score_defense_on_team_table(id_sub)

    db.modify_score_attack_on_team_table(id_attack)
