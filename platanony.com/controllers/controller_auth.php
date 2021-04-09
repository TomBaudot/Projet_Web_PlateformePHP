<?php


    $path_to_index_dir = '../';
    if (!defined('ROOT_PATH')){

        require_once('../page_access_manager.php');
    }
    else
    {
        require_once(ROOT_PATH .'/page_access_manager.php');
    }


    class AuthController {

        public function __construct(){}

        public function signin() {
            /**
             * Méthode permettant de s'authentifier. Si l'utilisateur n'est pas passé par le formulaire
             * d'authentification pour arriver ici, on affiche le formulaire.
             * Si l'utilisateur a rentré des identifiants valides, on peut créer une session avec son login. Sinon,
             * on affiche un message d'erreur.
             */
            // Si on a pas encore appuyé une fois sur le bouton de soumission du formulaire d'authentification
            if (!isset($_POST['login_btn'])){
                require_once(ROOT_PATH . '/views/auth/signin.php');
            }
            // Si on a déjà appuyé,
            else
            {
                // et que nous avons bien rempli tous les champs requis, on peut regarder dans la BDD pour voir si l'authentification est bonne
                if (isset($_POST['team_name']) && !empty($_POST['team_name']) && isset($_POST['password']) && !empty($_POST['password'])){

                    $cur_team = new Team();

                    $result = $cur_team->authentificate($_POST['team_name'], $_POST['password']);

                    if ($result[0]){

                        $_SESSION['team_name'] = $_POST['team_name'];

                        $_SESSION['password'] = $result[1];

                        routing('accueil', 'home');
                    }
                    // Si notre login/mdp n'est pas bon, on affiche un message d'erreur
                    else{

                        $error_msg = "Incorrect team's name/password";
                        require_once(ROOT_PATH . '/views/auth/signin.php');

                    }



                }
                else
                    // Si un des champs n'est pas rempli, on affiche un message d'erreur
                {
                    $error_msg = "Please fill out the entire form";
                    require_once(ROOT_PATH . '/views/auth/signin.php');
                }
            }


        }

        public function signout() {
            /**
             * Méthode remettant l'élément $_SESSION à son état initial. Permet donc de se déconnecter.
             */

            $_SESSION = array();

            require_once(ROOT_PATH . '/views/auth/signin.php');
        }

 }
?>
