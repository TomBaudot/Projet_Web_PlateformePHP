<!-- Distribution model -->

<?php
    class Distribution
    {
        public $id_team;
        public $team_name;
        public $file;

        public function __construct($id_team = false,  $team_name = false, $file = false) {
            if ($id_team === false) return;

            $this->id_team = $id_team;
            $this->team_name = $team_name;
            $this->file = $file;
        } //end construct

        public function get_files() {

            global $con;
            $sql = "SELECT * FROM distribution";
            $reponse = $con->query($sql);
            return $reponse;
        }
    }