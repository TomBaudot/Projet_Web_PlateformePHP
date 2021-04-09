import numpy as np
import pandas as pd
from pandas import DataFrame
import database


def gen_classement_file(db):
    """
    Génere la première page du rapport (résultat du concours)
    :param name_file: Nom du fichier pour le rapport
    """
    a = ['Id', 'Nom', 'Score attaque', 'Score défense']

    array = np.asarray(db.get_scoreboard())
    colonne = list()
    for j in range(len(array[0])):
        colonne.append([array[i][j] for i in range(len(array))])
    df = DataFrame({"Id": colonne[0], "Nom": colonne[1], "Score attaque": colonne[2], "Score défense": colonne[3],
                    "Moyenne Score": colonne[4]})
    return df

def team_page(db):
    """
    Récupère deux listes de dataframes contenant toutes les données pour les feuilles des équipes
    :return deux listes de dataframes contenant toutes les données pour les feuilles des équipes
    """

    array = np.asarray(db.get_scoreboard())
    dfArray = list()
    dfAtk = list()
    for i in range(len(array)):
        dfArray.append(gen_page_team(array[i][0], db))
        dfAtk.append(gen_page_atk(array[i][0], db))
    return dfArray, dfAtk

def gen_page_team(id_team, db):
    """
    Renvoit l'id de la team ainsi qu'un datatframe comportant toute les données sur ses soumissions
    :param l'id de la team
    :return l'id de la team ainsi qu'un datatframe comportant toute les données sur ses soumissions
    """

    array = np.asarray(db.get_all_submission(id_team))
    colonne = list()
    if(len(array) != 0):
        for j in range(len(array[0])):
            colonne.append([array[i][j] for i in range(len(array))])
        df = DataFrame({"Id": colonne[0], "Nom soumission": colonne[1], "Score utilité": colonne[2], "Score défense": colonne[3],
                        "date upload": colonne[4]})
        return id_team, df
    return id_team, None

def gen_page_atk(id_team, db):
    """
       Renvoit l'id de la team ainsi qu'un datatframe comportant toute les données sur ses attaques
       :param l'id de la team
       :return l'id de la team ainsi qu'un datatframe comportant toute les données sur ses attaques
       """

    array = np.asarray(db.get_all_attack(id_team))
    #id_attack, name_attack, score_attack, DATE_FORMAT(date_attack, '%d/%m/%Y %H:%i:%s'), name_soumission, name_team
    colonne = list()
    if(len(array) != 0):
        for j in range(len(array[0])):
            colonne.append([array[i][j] for i in range(len(array))])
        df = DataFrame({"Id": colonne[0], "Nom attaque": colonne[1], "Score d'attaque": colonne[2], "Date attaque": colonne[3],
                        "Nom soumission": colonne[4], "Nom de l'équipe attaqué": colonne[5]})
        return id_team, df
    return id_team, None


def statistique_page(db):
    """
    Créer la page des stats de la compétition
    """

    average = db.get_averages()
    df2 = pd.DataFrame(np.array([["Nombre d'équipes", db.get_the_number_of("team")],
                                ["Nombre de soumission", db.get_the_number_of("soumission")],
                                 ["Nombre d'attaque", db.get_the_number_of("attack")],
                                ["Moyenne d'utilité des soumissions", average[0]], ["Moyenne de défense des soumissions",
                                average[1]], ["Moyenne du score d'attaque des équipes", average[2]],
                                 ["Moyenne du score d'attaque des équipes", average[3]]]))
    return df2

def gen(name_file):
    """
    Génère le rapport
    :param le nom du fichier
    """
    db = database.Database()

    df1 = gen_classement_file(db)
    df2, df4 = team_page(db)
    df3 = statistique_page(db)
    with pd.ExcelWriter('report/'+name_file+'.xlsx') as writer:
        df3.to_excel(writer, sheet_name='Statistiques')
        df1.to_excel(writer, sheet_name='Résultat')
        for i,j in df2:
            if j is not None:
                j.to_excel(writer, sheet_name=str(db.get_name_team(i))+"_soumissions")
        for i, j in df4:
            if j is not None:
                j.to_excel(writer, sheet_name=str(db.get_name_team(i)) + "_attaques")
