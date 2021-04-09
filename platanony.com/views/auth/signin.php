<?php
    $path_to_index_dir = '../../';
    if (!defined('ROOT_PATH')){

        require_once('../../page_access_manager.php');
    }
    else
    {
        require_once(ROOT_PATH .'/page_access_manager.php');
    }

    require_once(ROOT_PATH . '/includes/banner_login.php');
