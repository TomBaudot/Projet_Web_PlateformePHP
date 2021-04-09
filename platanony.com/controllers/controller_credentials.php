<?php

    $path_to_index_dir = '../';
    if (!defined('ROOT_PATH')){

        require_once('../page_access_manager.php');
    }
    else
    {
        require_once(ROOT_PATH .'/page_access_manager.php');
    }

    // Bool pour indiquer que l'utilisateur est une personne non-authentifiée. Vrai par défaut
    $is_anon = true;

    // Bool pour indiquer que l'utilisateur est une équipe. Faux par défaut
    $is_team = false;

    // On ne fait pas de bool pour l'admin car celui-ci peut aller où il veut par défaut

    // On regarde si les identifiants de la personne connectée sont valides
    if(isset($_SESSION['admin_name']) && isset($_SESSION['admin_password'])){

        $is_anon = false;

    }
    else if (isset($_SESSION['team_name']) && isset($_SESSION['password'])){

        $is_team = true;

        $is_anon = false;

    }

    // Si l'utilisateur est une équipe
    if ($is_team){
        // A discuter
        $team_controller_values = ['auth', 'accueil', 'soumission', 'attack', 'competition', 'distribution', 'team_ranking'];

        // Si action non-autorisée par ses droits, on redirige vers index.php
        if(!in_array($controller, $team_controller_values)){
            header("Location: index.php");
            exit();
        }
    }
    // Si c'est un anon
    else if ($is_anon){
        // A discuter
        $anon_controller_values = ['auth', 'admin_auth', 'accueil', 'team_ranking', 'competition'];

        // Si action non-autorisée par ses droits, on redirige vers index.php
        if(!in_array($controller, $anon_controller_values)){
            header("Location: index.php");
            exit();
        }


      }
