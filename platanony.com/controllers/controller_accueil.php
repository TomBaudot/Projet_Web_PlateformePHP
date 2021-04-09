<?php
require_once(ROOT_PATH.'/models/tickets.php');

class accueilController {

    public function __construct(){}

    public function home() {
        $objet = new Ticket();
        $ticketsAlreadySaved=$objet->getTicket(); // TODO A remplacer par la valeur du token de connexion

        $is_logged = false;

        if(isset($_SESSION['admin_name']) && isset($_SESSION['admin_password']))
        {
          require_once(ROOT_PATH.'/models/admin.php');

          $cur_admin = new Admin();

          if ($cur_admin->authentificate($_SESSION['admin_name'], $_SESSION['admin_password'])){
              $is_logged = true;

          }

        }
        else if (isset($_SESSION['team_name']) && isset($_SESSION['password'])){

          require_once(ROOT_PATH.'/models/team.php');

          $cur_team = new Team();

          if ($cur_team->authentificate($_SESSION['team_name'], $_SESSION['password'])){

              $is_logged = true;
        }
    }

        require_once(ROOT_PATH.'/home.php');
    }

    public function submitTicket() {
        $objet = new Ticket();
        if(isset($_POST['title']) && isset($_POST['data'])) {
            $objet->submitTicket(0, $_POST['title'], $_POST['data']);
        }

        header("location:index.php?controller=accueil&action=home");
    }

}
?>
