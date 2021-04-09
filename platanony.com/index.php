<?php
    session_start();


// Si une équipe est connectée
    if (isset($_SESSION['team_name']) && isset($_SESSION['password'])){
        if(isset($_GET['controller']) && isset($_GET['action']) && !($_GET['controller'] == 'auth' && $_GET['action'] == 'signin')){
            $controller= $_GET['controller'];
            $action=$_GET['action'];
        }
        else{
            $controller='accueil';
            $action='home'; // On va sur la page pour afficher les concours par défaut
        }

    }
    // Si l'administrateur s'est authentifié
    else if (isset($_SESSION['admin_name']) && isset($_SESSION['admin_password'])){
        if(isset($_GET['controller']) && isset($_GET['action']) && !($_GET['controller'] == 'admin_auth' && $_GET['action'] == 'signin')){
            $controller= $_GET['controller'];
            $action=$_GET['action'];
        }
        else{
            $controller='accueil';
            $action='home'; // On va sur la page pour afficher les fichiers F par défaut
        }

    }
    // Si l'utilisateur n'est pas authentifié
    else{
        if (isset($_GET['controller']) && isset($_GET['action'])){
            $controller= $_GET['controller'];
            $action=$_GET['action'];
        }
        else
        {
            $controller='auth';
            $action='signin'; // On va sur la page pour s'authentifier par défaut
        }

    }



  require_once('views/index.php');
