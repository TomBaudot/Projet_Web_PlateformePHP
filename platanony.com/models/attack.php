<!-- Exemple de model -->

<?php
require_once(ROOT_PATH.'/database/db.php');
class Attack
{
    public $id;
    public $name;
    public $score;
    public $id_team;
    public $id_soumission;
    public $date_attack;

    public function __construct($id = false, $nom = false, $score= false, $date_attack=false ,$id_team = false, $id_soumission=false) {
        if ($id === false) return;

        $this->id = $id;
        $this->name = $nom;
        $this->score = $score;
        $this->date_attack = $date_attack;
        $this->id_team = $id_team;
        $this->id_soumission = $id_soumission;
    } //end construct

    public function get_file($id_team, $id_submission)
    {
        try {
            $con = DBConnect::getInstance();
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_team = htmlspecialchars($id_team);

            $id_submission = htmlspecialchars($id_submission);

            $query = $con->prepare("SELECT * FROM attack WHERE id_team = :id_team AND id_soumission = :id_submission ORDER BY date_attack DESC");

            $result = $query->execute(array("id_team" => $id_team, "id_submission" => $id_submission));

            if($result) {
                foreach ($query as $soumis) {
                    $list[] = new Attack($soumis['id_attack'], $soumis['name_attack'], $soumis['score_attack'], $soumis['date_attack'], $soumis['id_team'], $soumis['id_soumission']);
                }
                if (isset($list)) {
                    return $list;
                }

            }

            return NULL;


        }
        catch (PDOException $e)
        {
            echo $sql . "</br>".$e->getMessage();
        }



    }

    public function getIDAttack($name, $id_team, $id_submission){

      $con = DBConnect::getInstance();

      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $name = htmlspecialchars($name);

      $id_team = htmlspecialchars($id_team);

      $id_submission = htmlspecialchars($id_submission);

      $q1 = $con->prepare("SELECT id_attack FROM attack WHERE name_attack = :name AND id_team = :id_team AND id_soumission =:id_submission");

      $result = $q1->execute(array("name" => $name, "id_team" => $id_team, "id_submission" => $id_submission));

      if($result && ($q1->rowCount() > 0)){

        $arr = $q1->fetch();

        if(array_key_exists('id_attack', $arr)){

          $id_attack = $arr['id_attack'];

          return $id_attack;
        }
      }

      return $result;

    }

    public function nameAlreadyExists($name){
      $con = DBConnect::getInstance();

      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $name = htmlspecialchars($name);

      $q1 = $con->prepare("SELECT name_attack FROM attack WHERE name_attack = :name_attack");

      $q1->execute(array("name_attack" => $name));

      return ($q1->rowCount() !== 0);

    }

    public function write_file($id, $name, $score,$id_team, $id_soumission)
    {
        try {
            $con = DBConnect::getInstance();

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = htmlspecialchars($id);

            $name = htmlspecialchars($name);

            $score = htmlspecialchars($score);

            $id_team = htmlspecialchars($id_team);

            $id_soumission = htmlspecialchars($id_soumission);

            $query = $con->prepare("INSERT INTO attack (id_attack, name_attack, score_attack, date_attack, id_team, id_soumission)
      VALUES (:id, :name, :score, NOW(), :id_team, :id_soumission)");

            $result = $query->execute(array("id" => $id , "name" => $name, "score" => $score, "id_team" => $id_team, "id_soumission" => $id_soumission));

            return $result;
        }
        catch(PDOException $e)
        {
            return false;
        }


    }

    public function delete_file($name)
    {

      $name = preg_replace("/[.]{2,}/", "", $name);

      $name = preg_replace("/[*\/*]/", "", $name);

      $name = preg_replace("/[*%*]/", "", $name);

        if(file_exists(ROOT_PATH . '/attack/' . $name)){

          try {
              $con = DBConnect::getInstance();
              $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //delete file
              unlink(ROOT_PATH . '/attack/' . $name);

              $query = $con->prepare("DELETE FROM attack WHERE name_attack = :name");

              $result = $query->execute(array("name" => $name));

              return $result;


          } catch (PDOException $e) {}
      }

      return false;


    }

    public function getAttackCount($id_team, $id_submission){

      global $con;

      $id_team = htmlspecialchars($id_team);

      $id_submission = htmlspecialchars($id_submission);

      $query = $con->prepare("SELECT COUNT(*) AS nb_attack FROM `attack` WHERE id_team = :id_team AND id_soumission = :id_submission");

      $result = $query->execute(array('id_team' => $id_team, 'id_submission' => $id_submission));

      if($result){

        $arr = $query->fetch();

        if(array_key_exists('nb_attack', $arr)){

          return $arr['nb_attack'];


        }

      }

      return -1;


    }

    public function getAttackIDFromFile($name){

      global $con;

      $name = htmlspecialchars($name);

      $query = $con->prepare("SELECT id_team FROM attack WHERE name_attack = :name");

      $result = $query->execute(array('name' => $name));

      if($result){

        $arr = $query->fetch();

        if(array_key_exists('id_team', $arr)){

          return $arr['id_team'];


        }

    }

    return -1;

  }

}//end class Order
