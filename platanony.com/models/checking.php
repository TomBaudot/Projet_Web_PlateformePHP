<!-- Distribution model -->

<?php
class Checking
{
    public function __construct() {}

    public function get_time() {
        try {
            $con = DBConnect::getInstance();

            $query = $con->query( "SELECT date FROM countdown ORDER BY id DESC LIMIT 0,1");
            $resultat = $query->fetch();

            return $resultat;

        }
        catch (PDOException $e){
            echo "<br>" . $e->getMessage();
        }

    }
}

?>