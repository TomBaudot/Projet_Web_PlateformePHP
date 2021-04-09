<?php
require_once(ROOT_PATH.'/models/attack.php');
require_once(ROOT_PATH.'/models/team.php');
require_once(ROOT_PATH . '/models/soumission.php');
class attackController {

    public function __construct(){}

    public function execInBackground($cmd){
        /**
         * Fonction permettant d'exécuter un script en background
         * @param cmd : La commande à exécuter
         */

        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &");
        }

    }

    public function upload() {

        $objet = new Attack();
        $team = new Team();
        $submission = new Soumission();
        $attack_uploaded = false;

        $n_attack = $objet->getAttackCount($team->getTheIdWithSession(), $_GET['id_soumission']);

        if(isset($_GET['id']) && isset($_GET['nom_fichier']) && isset($_GET['id_team']) && isset($_GET['id_soumission']) && file_exists(ROOT_PATH . '/attack/' . $_GET['nom_fichier']) && !$objet->nameAlreadyExists($_GET['nom_fichier']) && ($n_attack < 3))
        {
            if($objet->write_file($_GET['id'], $_GET['nom_fichier'], -1,$team->getTheIdWithSession(), $_GET['id_soumission'])){
              $attack_uploaded = true;
            }

            $id_attack = $objet->getIDAttack($_GET['nom_fichier'], $team->getTheIdWithSession(), $_GET['id_soumission']);

            $name_f_file_sub = $submission->getNameFfile($_GET['id_team'], $_GET['id_soumission']);

            $name_f_file_attack = substr($_GET['nom_fichier'], 0, strpos($_GET['nom_fichier'], "."));

            if($id_attack != false && $name_f_file_sub != false){

              $this->execInBackground("python3 script/command_line_handler.py --action compute_score_attack --param " . $id_attack . " " . ROOT_PATH . "/uploads/F_files_directory/" . $name_f_file_sub . " " . ROOT_PATH . "/attack/" . $name_f_file_attack);

            }
            else{
              $attack_uploaded = false;
            }
        }

        if($attack_uploaded){
            $success_msg = "Le fichier a bien été téléchargé par notre site.";

            if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                $success_msg = "The file has been successfully uploaded.";
            }

            require_once(ROOT_PATH . '/includes/success.php');

        }
        else{
            $error_msg = "Une erreur est intervenue lors du téléchargement du fichier.";

            if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                $error_msg = "An error occurred on the server while your file was uploaded.";
            }

            require_once(ROOT_PATH . '/includes/error.php');

        }


    }
    public function delete(){
        $objet = new Attack();

        $team = new Team();

        $id_session = $team->getTheIdWithSession();

        if(isset($_GET['nom_fichier']) && ($id_session == $objet->getAttackIDFromFile($_GET['nom_fichier'])))
        {

            if($objet->delete_file($_GET['nom_fichier'])){

              $success_msg = "L'attaque a bien été supprimée.";

              if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                  $success_msg = "The attack has been successfully deleted.";
              }

              require_once(ROOT_PATH . '/includes/success.php');

            }
            else {

              $error_msg = "Échec de la suppression de l'attaque pour des raisons inconnues.";

              if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                  $error_msg = "Failed to remove the attack for unknown reasons.";
              }

              require_once(ROOT_PATH . '/includes/error.php');

            }

        }
        else{

          $error_msg = "Problème d'URL.";

          if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
              $error_msg = "URL problem.";
          }

          require_once(ROOT_PATH . '/includes/error.php');

        }


    }
    public function uploadAttack() {

        $objet = new Attack();
        $team = new Team();
        $fileAlreadySaved = $objet->get_file($team->getTheIdWithSession(), $_GET['id_soumission']);

        $max_n_attack = 3;

        $n_attack = $objet->getAttackCount($team->getTheIdWithSession(), $_GET['id_soumission']);

        require_once('views/uploadAttaque.php'); //On affiche la page, l'objet objets sera setup

    }

    public function print_error(){
      if (isset($_GET['error']) && !empty($_GET['error'])){

        switch ($_GET['error']) {

            case 'file_exists':
                $error_msg = "Un fichier avec le même nom existe déjà. Merci de changer le nom de votre fichier.";

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = "A file with the same name already exists. Please change the file's name";
                }
                break;

            case 'mime':
                $error_msg = "Votre fichier ne ressemble pas à un fichier json...";

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = "Your file doesn't seem to be a json file...";
                }
                break;

            case 'extension':
                $error_msg = 'L\'extension de votre fichier n\'est pas ".json"';

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = 'Your file extension isn\'t ".json"';
                }
                break;

            case 'size':
                $error_msg = "Votre fichier est trop gros pour être téléchargé";

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = "Your file is too big to be downloaded";
                }
                break;

            case 'unknown':
                $error_msg = "Erreur inconnue lors de la soumission.";

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = "An unknown error occured during the submission";
                }
                break;

            default :
             $error_msg = "Echec du téléchargement.";

             if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                 $error_msg = "Download failure";
             }
        }

        require_once(ROOT_PATH . '/includes/error.php');

      }
    }



}
?>
