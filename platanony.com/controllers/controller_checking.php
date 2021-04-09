<?php
require_once(ROOT_PATH.'/models/checking.php');
class CheckingController {

    public function __construct(){
    }


    public function checkCR() {
        $check = new Checking();
        $countdown = $check->get_time();

        require_once(ROOT_PATH .'/views/checkingCR.php');
    }

}
?>