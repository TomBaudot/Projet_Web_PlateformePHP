<?php


$path_to_index_dir = '../';
if (!defined('ROOT_PATH')){

    require_once('../page_access_manager.php');
}
else
{
    require_once(ROOT_PATH .'/page_access_manager.php');
}


class CompetitionController {

    public function __construct(){}

    public function displayCompetition(){
        /**
         * Affiche la page "concours" avec tous les liens nécessaires
         */
        require_once(ROOT_PATH . '/views/competition.php');
    }

}
?>