<?php
    define('ROOT_PATH', realpath(dirname(__FILE__)));
    define('BASE_URL', 'http://localhost:3000/');
    define('DIR_NAME',dirname($_SERVER['SCRIPT_NAME']));
    require_once(ROOT_PATH . '/database/db.php');
    require_once(ROOT_PATH . '/page_access_manager.php');
    // connect to database
    $con = DBConnect::getInstance();

    $path_to_index_dir = '';
    require_once(ROOT_PATH .'/page_access_manager.php');

    require_once (ROOT_PATH . '/controllers/controller_credentials.php');

