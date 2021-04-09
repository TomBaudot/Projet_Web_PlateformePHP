<?php


$path_to_index_dir = '../';
if (!defined('ROOT_PATH')){

    require_once('../page_access_manager.php');
}
else
{
    require_once(ROOT_PATH .'/page_access_manager.php');
}
require_once(ROOT_PATH.'/models/tickets.php');

class AdminController {

    public function __construct(){}

    public function displayFfiles(){
        /**
         * Affiche la page chargée d'afficher un lien vers un fichier F en fonction de l'équipe choisie
         */
        require_once (ROOT_PATH . '/models/team.php');

        $team = new Team();

        $teams_data = $team->getAllTeams();

        $teams_data2 = $team->getAllTeams();

        unset($team);

        require_once (ROOT_PATH . '/views/search_F_files.php');

    }

    public function deleteTicket()
    {
      $ticket_deleted = false;
      if(isset($_GET['id_ticket'])){

        $objet = new Ticket();
        $ticket_deleted = $objet->deleteTicket($_GET['id_ticket']);
        if ($ticket_deleted){
            $success_msg = "Le ticket a bien été supprimé.";
        }
        else {
            $error_msg = "Problème lors de la suppression du ticket";
        }
        require_once(ROOT_PATH . '/includes/success.php');
    }
  }
    public function manageTicket()
    {
      $objet = new Ticket();
      $ticketsAlreadySaved=$objet->getTicket();
      require_once(ROOT_PATH . '/views/admin/write_information.php');

    }

    public function submitTicket() {
        $objet = new Ticket();

        $ticket_uploaded = false;

        if(isset($_POST['title']) && isset($_POST['data'])) {

            $ticket_uploaded = $objet->submitTicket(0, $_POST['title'], $_POST['data']);
        }

        if ($ticket_uploaded){
            $success_msg = "Le ticket a bien été posté.";

            if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                $success_msg = "The ticket has been successfully posted.";
            }

            require_once(ROOT_PATH . '/includes/success.php');

        }
        else{
            $error_msg = "Une erreur est intervenue lors de l'envoi du ticket.";

            if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
                $error_msg = "An error occurred with your ticket.";
            }

            require_once(ROOT_PATH . '/includes/error.php');

        }
    }


    public function sent_time() {
        try {

        $id = 0;

        $con = DBConnect::getInstance();

        $query = $con->prepare("INSERT INTO countdown (id, date) VALUES (:id, NOW()) ");
        $result = $query->execute(array('id' => $id));

        $success_msg = "Le compte à rebours a été lancé.";

        if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
            $success_msg = "The countdown has been launched";
        }

        require_once(ROOT_PATH . '/includes/success.php');

        }
        catch (PDOException $e){
          $error_msg = "Une erreur est intervenue lors du lancement.";

          if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "eng"){
              $error_msg = "An error occurred while launching the countdown.";
          }

          require_once(ROOT_PATH . '/includes/error.php');
        }

    }

    public function manageCR()
    {
        require_once(ROOT_PATH . '/views/compteR.php');
    }
}
?>
