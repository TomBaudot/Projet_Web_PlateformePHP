<!-- Exemple de routeur -->
<?php
    $path_to_index_dir = '../';
    if (!defined('ROOT_PATH')){

        require_once('../page_access_manager.php');
    }
    else
    {
        require_once(ROOT_PATH .'/page_access_manager.php');
    }


function routing($controller, $action)
{
    require_once(ROOT_PATH . '/controllers/controller_' . $controller . '.php');
    switch ($controller) {

        case 'auth': // Authentification seulement pour l'instant
            require_once(ROOT_PATH . '/models/team.php');
            $myController = new AuthController();
            break;

        case 'accueil':
            $myController = new accueilController();
            break;

        case 'soumission':
            $myController = new soumissionController();
            break;

        case 'attack':
            $myController = new attackController();
            break;

        case 'competition':
            $myController = new CompetitionController();
            break;

        case 'manage':
            require_once(ROOT_PATH . '/models/team.php');
            $myController = new teamController();
            break;

        case 'distribution':
            require_once(ROOT_PATH . '/models/distribution.php');
            $myController = new distributionController();
            break;

        case 'admin_auth':
            require_once(ROOT_PATH . '/models/admin.php');
            $myController = new AdminAuthController();
            break;

        case 'admin':
            $myController = new AdminController();
            break;

        case 'team_ranking':
            $myController = new TeamRankingController();
            break;

        case 'checking':
            $myController = new CheckingController();
            break;

    }

    $myController->{$action}();
}

//Fait la correspondance entre controller et les actions possibles pour chaque controller
$controllers = array(
    'auth' => ['signin', 'signout'],
    'accueil' => ['home'],
    'soumission' => ['upload', 'uploadSoumission', 'print_error', 'listfiles'],
    'attack' => ['upload', 'uploadAttack', 'delete', 'print_error'],
    'competition' => ['displayCompetition'],
    'admin_auth' => ['signin', 'signout'],
    'admin' => ['displayFfiles', 'manageTicket', 'submitTicket','sent_time','get_time','manageCR', 'deleteTicket'],
    'distribution'=> ['search'],
    'manage' => ['home', 'uploadTeam', 'deleteTeam', 'changeScore'],
    'team_ranking' => ['displayTeamRanking'],
    'checking' => ['checkCR']

);


if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        routing($controller, $action);
    } else {
      //Page par défaut
        routing('accueil', 'home');
    }
} else {
    //TODO
    routing('accueil', 'home');
}
