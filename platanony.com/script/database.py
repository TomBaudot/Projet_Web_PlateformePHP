import mysql.connector

# Connexion à la BDD

class Database:

    def __init__(self):


        self.mydb = mysql.connector.connect(
            host="localhost",
            user="user",
            password="7ds5;k2-q~Ph[7mn",
            database="plat_anon"
        )


    def modify_utility(self, id_submission: int, score_utility: float) -> None:
        """
        Modifie le score d'utilité d'une ligne
        :param id_submission: Un id de soumission
        :param score_utility: Un score d'utilité
        :return: None
        """

        mycursor = self.mydb.cursor()

        query = "UPDATE soumission SET score_utility = " + str(score_utility) + " WHERE id_soumission = " + str(id_submission)

        mycursor.execute(query)

        self.mydb.commit()


    def init_defense_submission(self, id_submission: int, score_utility: float) -> None:
        """
        Modifie le score de défense lors de l'upload d'une soumission
        :param id_submission: Un id de soumission
        :param score_utility: Un score d'utilité
        :return: None
        """

        mycursor = self.mydb.cursor()

        query = "UPDATE soumission SET score_defense = " + str(score_utility) + " WHERE id_soumission = " + str(
            id_submission)

        mycursor.execute(query)

        self.mydb.commit()


    def modify_attack_score(self, id_attack: int, score_attack: float) -> None:
        """
        Modifie le score de l'attaque d'une ligne
        :param id_attack: Un id de soumission
        :param score_attack: Un score d'attaque
        :return: None
        """

        mycursor = self.mydb.cursor()

        query = "UPDATE attack SET score_attack = " + str(score_attack) + " WHERE id_attack = " + str(id_attack)

        mycursor.execute(query)

        self.mydb.commit()


    def modify_defense_submission(self, id_submission: int, score_defense: float) -> None:
        """
        Modifie le score de défense lors de l'upload d'une soumission
        :param id_submission: Un id de soumission
        :param score_defense: Un score de défense
        :return: None
        """

        mycursor = self.mydb.cursor()

        query = "UPDATE soumission SET score_defense = " + str(score_defense) + " WHERE id_soumission = " + str(
            id_submission)

        mycursor.execute(query)

        self.mydb.commit()


    def update_defense_submission(self, id_submission: int) -> None:
        """
        Modifie le score de défense lors de l'upload d'une soumission
        :param id_submission: Un id de soumission
        :return: None
        """

        mycursor = self.mydb.cursor()

        query = "SELECT score_utility * (1 - MAX(score_attack)) FROM " \
                "(SELECT attack.id_soumission, attack.score_attack, soumission.score_utility FROM attack, soumission " \
                "WHERE attack.id_soumission = soumission.id_soumission) AS new_table WHERE new_table.id_soumission = " \
                + str(id_submission)

        mycursor.execute(query)

        new_score_defense = mycursor.fetchone()[0]

        self.modify_defense_submission(id_submission, new_score_defense)


    def get_id_submission_from_attack(self, id_attack: int) -> int:
        """
        Récupère l'id de la soumission grâce à l'ID de l'attaque donné en param
        :param id_attack: L'ID de l'attaque
        :return: l'id de la soumission
        """

        mycursor = self.mydb.cursor()

        query = "SELECT id_soumission FROM attack WHERE id_attack = " + str(id_attack)

        mycursor.execute(query)

        return mycursor.fetchone()[0]


    def modify_score_defense_on_team_table(self, id_sub: int) -> None:
        """
        Modifie le score de défense d'une équipe dont un ID d'une de des soumissions est passé en param
        :param id_sub: L'ID de la soumission
        :return: None
        """

        mycursor = self.mydb.cursor()

        first_query = "SELECT MAX(score_defense) AS myScore FROM soumission, (SELECT id_team AS myID FROM soumission " \
                      "WHERE id_soumission = " + str(id_sub) + ") AS new_table WHERE id_team = new_table.myID"

        mycursor.execute(first_query)

        value = mycursor.fetchone()[0]

        second_query = "SELECT id_team FROM soumission WHERE id_soumission = " + str(id_sub)

        mycursor.execute(second_query)

        id_team = mycursor.fetchone()[0]

        third_query = "UPDATE team SET defense_score_team = " + str(value) + " WHERE id_team = " + str(id_team)

        mycursor.execute(third_query)

        self.mydb.commit()


    def modify_score_attack_on_team_table(self, id_attack: int) -> None:
        """
        Modifie le score d'attaque d'une équipe dont un ID d'une de des attaques est passé en param
        :param id_attack: L'ID de l'attaque
        :return: None
        """

        mycursor = self.mydb.cursor()

        first_query = "SELECT id_team FROM attack WHERE id_attack = " + str(id_attack)

        mycursor.execute(first_query)

        id_team = mycursor.fetchone()[0]

        second_query = "SELECT SUM(new_table2.score_min) FROM (SELECT MIN(new_table.score_attack) AS score_min FROM " \
                       "(SELECT attack.score_attack, soumission.id_team AS sidt, attack.id_team AS aidt FROM attack " \
                       "INNER JOIN soumission ON attack.id_soumission = soumission.id_soumission " \
                       "WHERE attack.id_team = " + str(id_team) + ") AS new_table GROUP BY sidt) AS new_table2"

        mycursor.execute(second_query)

        score_attack = mycursor.fetchone()[0]

        third_query = "UPDATE team SET attack_score_team = " + str(score_attack) + " WHERE id_team = " + str(id_team)

        mycursor.execute(third_query)

        self.mydb.commit()


    #Partie génération de rapport
    def get_scoreboard(self):
        """
        Récupère les informations des équipes
        :return: l'ensemble des infos (sauf mdp) de la table team
        """
        mycursor = self.mydb.cursor()

        query = "SELECT id_team, name_team, attack_score_team, defense_score_team,  (attack_score_team + defense_score_team)/2 as moyenne FROM team"

        mycursor.execute(query)

        return mycursor.fetchall()


    def get_all_submission(self, id_team):
        """
        Récupère la liste des soumissions d'une équipe
        :param id_team: l'id de l'équipe
        :return: La liste des soumissions de l'équipe dont l'id est passé en paramètre
        """
        mycursor = self.mydb.cursor()

        query = "SELECT id_soumission, name_soumission, score_utility, score_defense ,DATE_FORMAT(date_soumission, '%d/%m/%Y %H:%i:%s') From soumission where id_team =" + str(
            id_team)

        mycursor.execute(query)

        return mycursor.fetchall()

    def get_name_team(self, id_team):
        """
        Récupère le nom de l'équipe associé à l'id transmis
        :param id_team: L'id de l'équipe
        :return: Son nom
        """
        mycursor = self.mydb.cursor()

        query = "SELECT name_team FROM team WHERE id_team =" + str(id_team)

        mycursor.execute(query)

        return mycursor.fetchone()[0]


    def get_the_number_of(self, name_of_table):
        """
        Compte le nombre d'entrée dans la table passé en paramètre
        :param name_of_table: la table où on veut compter
        :return: son nombre d'entrée
        """
        mycursor = self.mydb.cursor()

        query = "SELECT count(*) FROM "+name_of_table

        mycursor.execute(query)

        var = mycursor.fetchone()[0]

        return var


    def get_averages(self):
        """
        Renvoies quelques statistiques sur la compétition (moyenne)
        :return: Retourne un tuple contenant 4 informations :
                1- Le score d'utilité moyen des soumissions
                2- Le score de défense moyen des soumissions
                3- Le score de défense des équipes moyen
                4- Le score d'attaque moyen des équipes
        """
        mycursor = self.mydb.cursor()

        query = "SELECT AVG(score_utility) FROM soumission"

        mycursor.execute(query)

        avg_utility = mycursor.fetchone()[0]

        query = "SELECT AVG(score_defense) FROM soumission"

        mycursor.execute(query)

        avg_defense = mycursor.fetchone()[0]

        query = "SELECT AVG(defense_score_team) FROM team"

        mycursor.execute(query)

        avg_defense_team = mycursor.fetchone()[0]

        query = "SELECT AVG(attack_score_team) FROM team"

        mycursor.execute(query)

        avg_attack_team = mycursor.fetchone()[0]

        return avg_utility, avg_defense, avg_attack_team, avg_defense_team

    def get_all_attack(self, id_team):
        """
        Récupère la liste des attaques d'une équipe
        :param id_team: l'id de l'équipe
        :return: La liste des attaques de l'équipe dont l'id est passé en paramètre
        """
        mycursor = self.mydb.cursor()

        query =  "SELECT id_attack, name_attack, score_attack, DATE_FORMAT(date_attack, '%d/%m/%Y %H:%i:%s'), name_soumission, name_team FROM attack, " \
                 "soumission, team WHERE attack.id_soumission = soumission.id_soumission and team.id_team = soumission.id_team " \
                 "and attack.id_team =" + str(id_team)

        mycursor.execute(query)

        return mycursor.fetchall()

    def remove_submission(self, id_sub):
        mycursor = self.mydb.cursor()

        query =  "DELETE from soumission WHERE id_soumission=" + str(id_sub)

        mycursor.execute(query)

        query = "DELETE from correspondence WHERE id_soumission=" + str(id_sub)

        mycursor.execute(query)
