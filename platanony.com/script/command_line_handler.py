import sys
import csv_file_handler
import score
import generation_rapport


# Les différents arguments utilisables
command_line_options = ['--action', '--param']

# Liste des différentes actions possibles et les fonctions associées à ces actions
action2function = {
    # Nom de l'action -> [la fonction à appeler, son nombre d'arguments]
    'generate_F_file': [csv_file_handler.generate_F_files_from_subfile, 6],
    'store_data': [csv_file_handler.store_data_file, 6],
    'compute_score_utility': [score.change_database_utility, 4],
    'compute_score_attack': [score.change_database_attack, 3],
    'generate_summary': [generation_rapport.gen, 1]

}


def get_action(arguments: list) -> str:
    """
    Récupère l'action à effectuer
    :param arguments: Les arguments données en ligne de commande
    :return: L'action à effectuer si elle existe sinon une chaine vide
    """
    if '--action' in arguments:
        ind = arguments.index('--action')
        if ind + 1 < len(arguments) and arguments[ind + 1] in action2function:
            return arguments[ind + 1]

    return ''


def get_parameters(arguments: list, n_param: int) -> list:
    """
    Récupère les paramètres qui seront utilisés par la fonction dont le nb de param nécessaire est passé en param
    :param arguments: Les arguments données en ligne de commande
    :param n_param: Le nombre de paramètres à utiliser pour la fonction
    :return: La liste de paramètres ou une liste vide si les paramètres ne sont pas correctes
    """

    if '--param' not in arguments or '--action' not in arguments:
        return []

    ind_param = arguments.index('--param')

    ind_action = arguments.index('--action')

    if ind_param > ind_action and len(arguments[ind_param + 1:]) == n_param:
        return arguments[ind_param + 1:]
    elif ind_param < ind_action and len(arguments[ind_param + 1:ind_action]) == n_param:
        return arguments[ind_param + 1:ind_action]
    else:
        return []


def execute_action(arguments: list) -> bool:
    """
    Exécute l'action décrite par les arguments de la ligne de commande si ceux-ci sont correctes
    :param arguments: Les arguments de la ligne de commande
    :return: Vrai si on a réussi à effectuer l'action, sinon faux
    """
    action = get_action(arguments)

    success = False
    print("go")
    # Si on a réussi à récupérer une action
    if action:
        print("action ok")

        # On récupère la fonction associée à cette action ainsi que son nombre de paramètres
        func, n_param = action2function[action]

        # On essaye de récupérer les paramètres de la fonction
        params = get_parameters(arguments, n_param)

        # Si on a réussi à obtenir les params, on peut exécuter la fonction
        if params:
            print("param ok")
            func(*params)
            print("Success")
            success = True

    return success


# Les arguments de la ligne de commande
arguments = list(sys.argv)

# Tentative d'exécution de l'éventuelle action de la ligne de commande
execute_action(arguments)
