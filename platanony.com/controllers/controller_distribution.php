<?php
    require_once(ROOT_PATH.'/models/team.php');
    $path_to_index_dir = '../';
    if (!defined('ROOT_PATH')){

        require_once('../page_access_manager.php');
    }
    else
    {
        require_once(ROOT_PATH .'/page_access_manager.php');
    }

    class distributionController {

        public function __construct(){
        }

        public function search() {
            $objet = new Team();
            $array_files = $objet->get_file_for_distribution();
            require_once(ROOT_PATH .'/views/distribution.php');
        }

        public function delete(){


        }




    }
?>