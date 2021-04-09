<?php
class teamController {

    public function __construct(){}

    public function home()
    {
      $objet = new Team();
      $teams = $objet->getAllTeam();
      require_once(ROOT_PATH .'/views/admin/manage_team.php');
    }

    //A securiser avec un token admin
    public function uploadTeam() {

        $objet = new Team();
        if(isset($_POST['team_name']) && isset($_POST['password']))
        {
            //$objet->generateSalt($_POST['team_name']);
            $objet->register($_POST['team_name'], $_POST['password']);
            $success_msg = "L'équipe a bien été créée.";
        }
        else {
          $error_msg = "L'équipe n'a pas été créée.";
        }

        require_once(ROOT_PATH . '/includes/success.php');
    }

    public function deleteTeam(){
      $objet = new Team();
      if(isset($_GET['id_team']))
      {
        $objet->delete($_GET['id_team']);
        $success_msg = "L'équipe a bien été supprimée.";
      }
      else {
        $error_msg = "L'équipe n'a pas été supprimée";
      }
      require_once(ROOT_PATH . '/includes/success.php');
    }

    public function changeScore(){
      $objet = new Team();
      if(isset($_GET['id_team']))
      {
        if(isset($_POST['scoreDefense']) && isset($_POST['scoreAttaque']))
        {
          $objet->changeScore($_POST['scoreAttaque'], $_POST['scoreDefense'], $_GET['id_team']);
          $success_msg = "Le score a été modifié.";
          require_once(ROOT_PATH . '/includes/success.php');
        }
        else {
          $error_msg = "Le score n'a pas été modifié";
          require_once(ROOT_PATH . '/includes/error.php');
        }
        }
      }

}
?>
