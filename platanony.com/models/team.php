<?php

$path_to_index_dir = '../';
if (!defined('ROOT_PATH')){

    require_once('../page_access_manager.php');
}
else
{
    require_once(ROOT_PATH .'/page_access_manager.php');
}



class Team
{
    public $id_team;
    public $team_name;
    public $password;
    public $score_team;
    public $defense_score_team;

    public function __construct($id_team=false, $team_name=false, $password=false, $attack_score_team=false, $defense_score_team=false)
        /**

         * Constructeur d'une équipe pariticipant à une compétition sur le site
         *@param id_team: Un id de team
         * @param team_name : Un nom de team
         * @param password : Le mot de passe associé
         * @param attack_score_team: Le score d'attaque de la team
         * @param defense_score_team : Le score de défense de la team
         *
         */
    {
        if ($team_name && $password){
            $this->id_team = $id_team;
            $this->team_name = $team_name;
            $this->password = $password;
            $this->score_team = $attack_score_team;
            $this->defense_score_team = $defense_score_team;
        }

    }
    public function getAllTeam(){
      /**
      *Récupère le nom, l'id et le score de toutes les équipes
      *@return : Le nom et l'id de toutes les équipes
      */
      global $con;
      $query = $con->query("SELECT * FROM team ORDER BY id_team");
      foreach ($query as $team)
      {
          $teams[] = new Team($team['id_team'], $team['name_team'], 1,$team['attack_score_team'], $team['defense_score_team']);
      }
      if(isset($teams))
      {
        return $teams;
      }
      return NULL;
    }

    public function exist($team_name){
        /**
         * Regarde si une équipe existe déjà dans la BDD
         * @param team_name : Un nom de team
         * @return : Vrai si l'utilisateur existe, faux dans le cas contraire
         */
        global $con;

        $team_name = htmlspecialchars($team_name);

        $query = $con->prepare("SELECT name_team FROM team WHERE name_team = :team_name");

        $query->execute(array('team_name' => $team_name));

        return ($query->rowCount() !== 0);
    }

    public function register($team_name, $password) {
        /**
         * Permet d'enregistrer une équipe dans la BDD s'il n'existe pas déjà
         * @param team_name : Un nom de team
         * @param password : Le mot de passe associé
         * @return : Vrai si on a réussi l'inscription, faux dans le cas contraire
         *
         */

        global $con;

        if (!$this->exist($team_name)){
            // Utilisation du hachage SHA512
            define(CRYPT_SHA512, 1);

            $salt = substr(md5(microtime()),rand(0,4),10);

            $saltedPassword = $salt . $password;
            $hashedPassword = hash("sha512", $saltedPassword, FALSE);

            // Requête pour ajouter la team dans la BDD

            $query = $con->prepare("INSERT INTO team(id_team, name_team, password_team, attack_score_team, defense_score_team) VALUES(NULL, :team_name, :password, 0, 0)");


            if($query->execute(array('team_name' => $team_name, 'password' => $hashedPassword))) {

                // Récupération de l'id de la team pour l'ajout du sel à la BDD
                $query_id = $con->prepare("SELECT id_team FROM team WHERE name_team = :team_name AND password_team = :password");
                $query_id->execute(array('team_name' => $team_name, 'password' => $hashedPassword));
                $result = $query_id->fetch();
                $id_team = $result['id_team'];

                // Requête pour ajouter le sel associé à la team dans la BDD
                $query_salt = $con->prepare("INSERT INTO salt(id_salt, salt, id_team) VALUES(NULL, :salt, :id_team)");
                return $query_salt->execute(array('salt' => $salt, 'id_team' => $id_team));
            }
        }

        return false;
    }

    public function authentificate($team_name, $password){
        /**
         * Vérifie si une équipe donnée et le mot de passe associé existent dans la base de données.
         * @param team_name : Un nom de team
         * @param password : Le mot de passe associé
         * @return : Vrai si l'équipe et son mdp existent dans la bdd, faux dans le cas contraire
         */
        global $con;

        $team_name = htmlspecialchars($team_name);

        $password = htmlspecialchars($password);

        // Récupération de l'ID de la team, s'il existe
        $query_id = $con->prepare("SELECT id_team FROM team WHERE name_team = :team_name");
        $query_id->execute(array('team_name'=>$team_name));
        $result_id = $query_id->fetch();
        $id_team = $result_id['id_team'];

        // Récupération du sel associé à l'équipe
        $query_salt = $con->prepare("SELECT salt FROM salt WHERE id_team = :id_team");
        $query_salt->execute(array('id_team'=>$id_team));
        $result_salt = $query_salt->fetch();
        $salt = $result_salt['salt'];

        // Génération du mot de passe hashé avec le sel
        $saltedPassword = $salt . $password;
        $hashedPassword = hash("sha512", $saltedPassword, FALSE);

        $query = $con->prepare("SELECT name_team, password_team FROM team WHERE name_team = :team_name and password_team = :password");

        //$query = $con->prepare("SELECT name_team, password_team FROM team WHERE name_team = :team_name and password_team = :password");

        $result = $query->execute(array('team_name' => $team_name, 'password' => $hashedPassword));

        if($result){
            $row = $query->fetch();

            return array($row != false, $hashedPassword); // On veut renvoyer un booléen et pas la ligne retournée
        }

        return $result;
    }

    public function getAllTeams(){
        /**
         * Récupère le nom de toutes les équipes
         * @return : un itérateur contenant le nom de chaque équipe
         */

        global $con;

        $query = $con->query("SELECT id_team, name_team FROM team");

        $result = $query->execute();

        if ($result){
            return $query;
        }

        return $result;
    }

    public function delete($id){
      /**
      *Supprime l'équipe portant l'id donné
      *@param id : l'id de la team
      */
      global $con;
      $id = htmlspecialchars($id);

      $query = $con->prepare("DELETE FROM team WHERE id_team = :id");
      $result = $query->execute(array('id' => $id));

    }


    public function search_files() {
        // On récupère les fichiers soumissions des équipe (les fichiers doivent être de la forme : nomteam_blabla.csv)
        // On stock retourne un tableau associatif 'nom_de_team' => array(fichier1, fichier2)
        global $con;
        $sql = "SELECT name_team FROM team";
        $reponse = $con->query($sql);
        $global_files = array();
        foreach($reponse as $name) {
            $files = array();
            if($dossier = opendir( ROOT_PATH ."/uploads/")) {
                while (false !== ($fichier = readdir($dossier))) {
                    $tmp = explode("_", $fichier);
                    if(count($tmp) > 1) {
                        if(strcasecmp($tmp[0], $name['name_team']) == 0) {
                            $files[] = $fichier;
                        }
                    }
                }
            }
            closedir($dossier);
            $global_files[$name['name_team']] = $files;
        }
        return $global_files;
    }

    public function getTheIdWithSession()
    {
        if(isset($_SESSION['team_name']))
        {
            global $con;

            $query = $con->prepare("SELECT id_team FROM team WHERE name_team = :team_name");

            $query->execute(array('team_name' => $_SESSION['team_name']));
            $reponse = $query->fetch();
            return $reponse['id_team'];
        }
    }

    public function get_file_for_distribution()
    {
        // On associe la table team et soumission pour récuperer les fichiers
        // soumission
        global $con;
        $sql = "SELECT * FROM soumission NATURAL JOIN team";
        $reponse = $con->query($sql);
        return $reponse;
    }

    public function getSubmissionCount(){

      global $con;

      $id = $this->getTheIdWithSession();

      $query = $con->prepare("SELECT COUNT(*) as nb_submission FROM `soumission` WHERE id_team = :id_team");

      $result = $query->execute(array('id_team' => $id));

      if($result){

        $arr = $query->fetch();

        if(array_key_exists('nb_submission', $arr)){

          return $arr['nb_submission'];


        }

      }

      return -1;


    }

    public function changeScore($attackScore, $defenseScore, $idteam){
      global $con;

      $query = $con->prepare("UPDATE team SET attack_score_team=:attack, defense_score_team=:defence WHERE id_team=:id");

      $result = $query->execute(array('id' => $idteam, 'attack' => $attackScore, 'defence' => $defenseScore));
    }



}
