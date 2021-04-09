<!-- Exemple de model -->

<?php
require_once(ROOT_PATH.'/database/db.php');
class Soumission
{
    public $id;
    public $name;
    public $score_utility;
    public $score_defense;
    public $id_team;
    public $date_submission;

    public function __construct($id = false, $nom = false, $score_utility= false, $score_defense = false, $date_submission=false, $id_team = false) {
        if ($id === false) return;

        $this->id = $id;
        $this->name = $nom;
        $this->score_utility = $score_utility;
        $this->score_defense = $score_defense;
        $this->id_team = $id_team;
        $this->date_submission = $date_submission;

    } //end construct

    public function get_file($id)
    {
        try {
            $con = DBConnect::getInstance();

            $id = htmlspecialchars($id);

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $con->prepare("SELECT * FROM soumission WHERE id_team = :id ORDER BY date_soumission DESC");

            $result = $query->execute(array("id" => $id));

            if ($result) {
                foreach ($query as $soumis) {
                    $list[] = new Soumission($soumis['id_soumission'], $soumis['name_soumission'], $soumis['score_utility'], $soumis['score_defense'], $soumis['date_soumission'], $soumis['id_team']);
                }
                if (isset($list)) {
                    return $list;
                }
            }

            return NULL;


        }
        catch (PDOException $e)
        {
            echo "</br>".$e->getMessage();
        }



    }

    public function getIdSubmission($name, $id_team){
      // A changer pour les params

      $con = DBConnect::getInstance();

      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $name = htmlspecialchars($name);

      $id_team = htmlspecialchars($id_team);

      $q1 = $con->prepare("SELECT id_soumission FROM soumission WHERE name_soumission = :name AND id_team = :id_team");

      $result = $q1->execute(array("name" => $name . ".csv", "id_team" => $id_team));

      if ($result && ($q1->rowCount() > 0)){

        $arr = $q1->fetch();

        if(array_key_exists('id_soumission', $arr)){

          $id_submission = $arr['id_soumission'];

          return $id_submission;

        }
      }

      return ($result && ($q1->rowCount() > 0));

    }

    public function nameAlreadyExists($name){
      $con = DBConnect::getInstance();

      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $name = htmlspecialchars($name);

      $q1 = $con->prepare("SELECT name_soumission FROM soumission WHERE name_soumission = :name_submission");

      $q1->execute(array("name_submission" => $name));

      return ($q1->rowCount() !== 0);

    }

    public function getNameSubmission($id){

      $con = DBConnect::getInstance();

      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $id = htmlspecialchars($id);

      $q1 = $con->prepare("SELECT name_soumission FROM soumission WHERE id_soumission = :id_submission");

      $result = $q1->execute(array("id_submission" => $id));

      if($result && ($q1->rowCount() > 0)){

        $arr = $q1->fetch();

        if(array_key_exists('name_soumission', $arr)){

          $name_submission = $arr['name_soumission'];

          return $name_submission;
        }
      }

      return $result;

    }

    public function getNameFfile($id_team, $id_submission){
      $con = DBConnect::getInstance();

      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $id_submission = htmlspecialchars($id_submission);

      $id_team = htmlspecialchars($id_team);

      $q1 = $con->prepare("SELECT name_correspondence FROM correspondence WHERE id_soumission = :id_submission AND id_team = :id_team");

      $result = $q1->execute(array("id_submission" => $id_submission, "id_team" => $id_team));

      if($result && ($q1->rowCount() > 0)){

        $arr = $q1->fetch();

        if(array_key_exists('name_correspondence', $arr)){

          $name_f_file = $arr['name_correspondence'];

          return $name_f_file;
        }
      }

      return $result;

    }

    public function write_file($id, $name, $score_utility,$id_team)
    {
        try {

            $con = DBConnect::getInstance();

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = htmlspecialchars($id);

            $name = htmlspecialchars($name);

            $score_utility = htmlspecialchars($score_utility);

            $id_team = htmlspecialchars($id_team);

            $query = $con->prepare("INSERT INTO soumission (id_soumission, name_soumission, score_utility, score_defense, date_soumission, id_team)
      VALUES (:id, :name, :score, 1, NOW(), :id_team)");

            $result = $query->execute(array("id" => $id , "name" => $name, "score" => $score_utility, "id_team" => $id_team));

            return $result;


        }
        catch(PDOException $e)
        {
            echo "<br>" . $e->getMessage();
            return false;

        }


    }

    public function save_correspondence($name, $id_team){
      try {

          $con = DBConnect::getInstance();

          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $name = htmlspecialchars($name);

          $id_team = htmlspecialchars($id_team);

          $q1 = $con->prepare("SELECT id_soumission FROM soumission WHERE name_soumission = :name AND id_team = :id_team");

          $result = $q1->execute(array("name" => $name . ".csv", "id_team" => $id_team));

          if($result && ($q1->rowCount() > 0)){

            $arr = $q1->fetch();

            if(array_key_exists('id_soumission', $arr)){

              $id_submission = $arr['id_soumission'];

              $query = $con->prepare("INSERT INTO correspondence (id_correspondence, name_correspondence, date_correspondence, id_team, id_soumission)
        VALUES (NULL, :name, NOW(), :id_team, :id_soumission)");

              $result2 = $query->execute(array("name" => 'F_' . $name, "id_team" => $id_team, "id_soumission" => $id_submission));

              return $result2;

            }

          }

          return $result;
      }
      catch(PDOException $e)
      {
          echo "<br>" . $e->getMessage();
          return false;

      }
    }

    public function delete_file($name)
    {
        try {
            $con = DBConnect::getInstance();
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $name = htmlspecialchars($name);

            $real_name = substr($name, 0, strpos($name, "."));

            $path_uploads = ROOT_PATH . '/uploads/';

            //delete files
            unlink($path_uploads . $name);

            unlink($path_uploads . "F_files_directory/F_" . $real_name . ".json");

            unlink($path_uploads . "L_files_directory/L_" . $real_name . ".pkl");

            unlink($path_uploads . "S_files_directory/S_" . $real_name . ".csv");

            $query = $con->prepare("DELETE FROM soumission WHERE name_soumission = :name");

            $result = $query->execute(array("name" => $name));

            $query = $con->prepare("DELETE FROM correspondence WHERE name_correspondence = :name");

            $result2 = $query->execute(array("name" => 'F_' . $real_name));

        } catch (PDOException $e) {
            echo "<br>" . $e->getMessage();
        }


    }

    public function isComplete($name){
        /**
         * Vérifie si la soumission est finie ou non
         * @param name : Le nom du fichier upload (après hash et avec .csv)
         * @return : Vrai si tous les fichiers (F, L et S) ont été créés, faux sinon
         */

        $real_name = substr($name, 0, strpos($name, "."));

        return (file_exists(ROOT_PATH . '/uploads/F_files_directory/F_' . $real_name . ".json") && file_exists(ROOT_PATH . '/uploads/L_files_directory/L_' . $real_name . ".pkl") && file_exists(ROOT_PATH . '/uploads/S_files_directory/S_' . $real_name . ".csv"));
    }

    public function hasBeenAttacked($name, $id_team){
        /**
         * Vérifie si la soumission est finie ou non
         * @param name : Le nom du fichier upload (après hash et avec .csv)
         * @param ID : l'ID de la team
         * @return : Vrai si tous les fichiers (F, L et S) ont été créés, faux sinon
         */


         $name = htmlspecialchars($name);

         $real_name = substr($name, 0, strpos($name, "."));

         $id_sub = $this->getIdSubmission($real_name, $id_team);

         if($id_sub != false){

           try {

               $con = DBConnect::getInstance();

               $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $q1 = $con->prepare("SELECT COUNT(*) AS nb_attack FROM attack WHERE id_soumission = :id_sub;");

               $result = $q1->execute(array("id_sub" => $id_sub));

               if($result && ($q1->rowCount() > 0)){

                 $arr = $q1->fetch();

                 if(array_key_exists('nb_attack', $arr)){

                   $nb_attack = $arr['nb_attack'];

                   return ($nb_attack > 0) ? 1 : 0;

                 }

               }

               return -1;
           }
           catch(PDOException $e)
           {
               echo "<br>" . $e->getMessage();
               return -1;

           }
         }

         return -1;


    }


    public function FilesPerTeam() {

      try {
        $con = DBConnect::getInstance();

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT *, COUNT(attack.id_attack) AS nb_attack FROM soumission NATURAL JOIN team LEFT JOIN attack ON soumission.id_soumission = attack.id_soumission GROUP BY attack.id_soumission ORDER BY soumission.id_team ";

        $result = $con->query($sql);
        if ($result) {
          return $result;
      }

        return NULL;


    }
    catch (PDOException $e)
    {
        echo "</br>".$e->getMessage();
    }
    }

}//end class Order
