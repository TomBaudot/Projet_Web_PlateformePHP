<?php
require_once(ROOT_PATH.'/models/soumission.php');
require_once(ROOT_PATH.'/models/team.php');
class soumissionController {

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

        $objet = new Soumission();
        $team = new Team();
        $file_uploaded = false;

        $n_sub = $team->getSubmissionCount();

        if(isset($_GET['id']) && isset($_GET['nom_fichier']) && isset($_GET['id_team']) && !$objet->nameAlreadyExists($_GET['nom_fichier']) && file_exists(ROOT_PATH . '/uploads/' . $_GET['nom_fichier']) && ($n_sub < 3))
        {

            if($objet->write_file($_GET['id'], $_GET['nom_fichier'], -1,$team->getTheIdWithSession())){
                $file_uploaded = true;
            }

            $name = substr($_GET['nom_fichier'], 0, strpos($_GET['nom_fichier'], "."));

            $key = $name . '.' . "csv";

            // Générer le fichier F
            $this->execInBackground("python3 script/command_line_handler.py --action generate_F_file --param " . ROOT_PATH . "/uploads/ " . ROOT_PATH . "/uploads/ " . ROOT_PATH . "/uploads/F_files_directory/ " . "org_data.csv " . $key . " " . $name);

            // Générer les fichiers S et L
            $this->execInBackground("python3 script/command_line_handler.py --action store_data --param " . ROOT_PATH . "/uploads/ " . ROOT_PATH . "/uploads/S_files_directory/ " . ROOT_PATH . "/uploads/L_files_directory/ " . $key . " " . $name . " " . $name);

            // Calcul score utilité

            $id_sub = $objet->getIdSubmission($name, $team->getTheIdWithSession());

            if($id_sub != false){

              $this->execInBackground("python3 script/command_line_handler.py --action compute_score_utility --param " . $id_sub . " " . ROOT_PATH . "/uploads/org_data.csv " . ROOT_PATH . "/uploads/" . $key . " " . 1000);

            }



            if (!$objet->save_correspondence($name, $team->getTheIdWithSession())){
              $file_uploaded = false;
            }

        }

        if($file_uploaded){
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
        $objet = new Soumission();

        $team = new Team();

        $attacked = $objet->hasBeenAttacked($_GET['nom_fichier'], $team->getTheIdWithSession());

        if(isset($_GET['nom_fichier']) && $objet->isComplete($_GET['nom_fichier']) && (!$attacked)) {

            $objet->delete_file($_GET['nom_fichier']);

            $success_msg = "La soumission a bien été supprimée.";

            if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                $success_msg = "The submission has been successfully deleted.";
            }

            require_once(ROOT_PATH . '/includes/success.php');
        }
        else if (!$objet->isComplete($_GET['nom_fichier'])){

            $error_msg = "La soumission n'est pas terminée du côté du serveur. Merci de patienter.";

            if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                $error_msg = "Your submission hasn't been fully treated on the server's side. Please try again later.";
            }

            require_once(ROOT_PATH . '/includes/error.php');
        }


        if($attacked == 1){

          $error_msg = "Votre soumission a déjà été attaquée et ne peut donc pas être supprimée.";

          if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
              $error_msg = "Your submission has already been attacked and therefore can't be removed.";
          }

          require_once(ROOT_PATH . '/includes/error.php');

        }
        else if($attacked == -1){

          $error_msg = "Une erreur est intervenue lors de la suppression de la soumission.";

          if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
              $error_msg = "An error occurred while trying to remove the submission.";
          }

          require_once(ROOT_PATH . '/includes/error.php');

        }

    }

    public function uploadSoumission() {

        $objet = new Soumission();

        $team = new Team();

        $fileAlreadySaved=$objet->get_file($team->getTheIdWithSession()); // TODO A remplacer par la valeur du token de connexion

        $max_n_sub = 3;

        $n_sub = $team->getSubmissionCount();

        if($n_sub == -1){

          $error_msg = "Erreur pour récupérer le nombre de soumissions de l'équipe.";

          if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
              $error_msg = "An error occurred while trying to get the number of submissions from your team.";
          }

          require_once(ROOT_PATH . '/includes/error.php');
        }

        require_once(ROOT_PATH . '/views/uploadSoumission.php'); //On affiche la page, l'objet objets sera setup

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
                $error_msg = "Votre fichier ne ressemble pas à un fichier csv...";

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = "Your file doesn't seem to be a csv file...";
                }
                break;

            case 'extension':
                $error_msg = 'L\'extension de votre fichier n\'est pas ".csv"';

                if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                    $error_msg = 'Your file extension isn\'t ".csv"';
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


    public function listfiles() {
        $objet = new Soumission();

        $res = $objet->FilesPerTeam();
        require_once(ROOT_PATH . '/views/allfiles.php');
    }

}
?>
