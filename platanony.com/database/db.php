<!-- Gère la connexion à la bdd -->
<?php

    $path_to_index_dir = '../';
    if (!defined('ROOT_PATH')){

        require_once('../page_access_manager.php');
    }
    else
    {
        require_once(ROOT_PATH .'/page_access_manager.php');
    }



class DBConnect
{
    private static $instance=NULL;
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PDO("mysql:host=localhost;dbname=plat_anon", "user", "7ds5;k2-q~Ph[7mn", NULL);
        }
        return self::$instance;
    }

    public static function closeInstance()
    {
        if (isset(self::$instance)) {
            self::$instance=NULL;
        }
    }
}
