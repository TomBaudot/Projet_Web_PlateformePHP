<?php
    if (!defined('ROOT_PATH')){
        define('ROOT_PATH', realpath(dirname(__FILE__)));
    }

    $files_included = get_included_files();

    $index_visited = false;

    foreach ($files_included as $file){

        if (($file == (ROOT_PATH . '\index.php')) || ($file == (ROOT_PATH . '/index.php'))){ // On regarde si le fichier index.php a déjà été inclu
            $index_visited = true;;

        }
    }

    if (!$index_visited){ // Si ce n'est pas le cas, on envoie l'utilisateur sur index.php
        header("Location:" . $path_to_index_dir. "index.php");
        exit();
    }