<?php

$path_to_index_dir = '../';
if (!defined('ROOT_PATH')){

    require_once('../page_access_manager.php');
}
else
{
    require_once(ROOT_PATH .'/page_access_manager.php');
}

/* test */

class Admin
{
    public $admin_name;
    public $password;

    public function __construct($admin_name=false, $password=false)
        /**
         * Constructeur d'un admin du site
         * @param admin_name : Le nom de l'admin
         * @param password : Le mot de passe associé
         *
         */
    {
        if ($admin_name && $password){
            $this->admin_name = $admin_name;
            $this->password = $password;
        }

    }

    public function authentificate($admin_name, $password){
        /**
         * Permet d'authentifier l'admin
         * @param admin_name : Le nom de l'admin
         * @param password : Le mot de passe associé
         * @return : Vrai si l'authentification a réussi, faux dans le cas contraire
         */
        global $con;

        $admin_name = htmlspecialchars($admin_name);

        $password = htmlspecialchars($password);

      	$file_salt = fopen('/home/user/admin_salt.txt', 'r');
      	$salt = fgets($file_salt);
        fclose($file_salt);
      	//echo($password .'</br>');
      	//echo($salt.'</br>');
      	$saltedPassword = $salt . $password;
      	$hashedPassword = hash("sha512", $saltedPassword, False);
      	//echo($hashedPassword);
        $query = $con->prepare("SELECT name_admin, password_admin FROM admin WHERE name_admin = :admin_name and password_admin = :password");

        $result = $query->execute(array('admin_name' => $admin_name, 'password' => $hashedPassword));

        if($result){
            $row = $query->fetch();
            return array($row != false, $hashedPassword); // On veut renvoyer un booléen et pas la ligne retournée
        }

        return $result;
    }

}
