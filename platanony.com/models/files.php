<?php

require_once ('../database/db_ajax.php');

class Files
{

    public function __construct(){}

    public function get_F_files($team_id){
        /**
         * Renvoie les informations des fichiers F associés à la team dont l'id est passé en paramètre
         * @param team_id: L'id de la team dont on veut récupérer son fichier f associé à sa soumission
         * @return : Une variable à fetch pour récupérer les info si la requête réussit, null dans le cas contraire
         */
        global $con2;

        $team_id = htmlspecialchars($team_id);

        $query = $con2->prepare("SELECT name_correspondence FROM correspondence WHERE id_team = :team_id ORDER BY date_correspondence DESC");

        $result = $query->execute(array('team_id' => $team_id));

        // Fermeture de co
        $con2 = null;

        if ($result){
            return $query;
        }
        else{
            return null;
        }





    }

    public function get_A_files($team_id){
        /**
         * Renvoie les informations des fichiers A associés à la team dont l'id est passé en paramètre
         * @param team_id: L'id de la team dont on veut récupérer son fichier A associé à sa soumission
         * @return : Une variable à fetch pour récupérer les info si la requête réussit, null dans le cas contraire
         */
        global $con2;

        $team_id = htmlspecialchars($team_id);

        $query = $con2->prepare("SELECT name_attack, score_attack FROM attack WHERE id_team = :team_id ORDER BY date_attack DESC");

        $result = $query->execute(array('team_id' => $team_id));

        // Fermeture de co
        $con2 = null;

        if ($result){
            return $query;
        }
        else{
            return null;
        }





    }

}
