<?php
  session_start();

  define('ROOT_PATH', realpath(dirname(__FILE__)));

  $is_logged = false;

  // Si on a une session
  if((isset($_SESSION['admin_name']) && isset($_SESSION['admin_password'])) || (isset($_SESSION['team_name']) && isset($_SESSION['password']))){
    $is_logged = true;
  }

  // Si on a une session
  if($is_logged){

    date_default_timezone_set('Europe/Paris');
    $date = date("H_i_s");
    $nameFile = "rapport_".$date;
    system("python3 script/command_line_handler.py --action generate_summary --param " .$nameFile);

    // Si on a reçu un nom de fichier en GET et qu'il existe alors on le télécharge
    if(file_exists(ROOT_PATH . '/report/' . $nameFile . '.xlsx')){

        $filename = ROOT_PATH . '/report/' . $nameFile . '.xlsx';
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime =  finfo_file($finfo, $filename);
        finfo_close($finfo);
        ob_end_clean();
        // send header information to browser
        header('Content-Type: '.$mime);
        header('Content-Disposition: attachment;  filename="'.$nameFile.'.xlsx"');
        header('Content-Length: ' . filesize($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        //stream file
        ob_get_clean();
        echo file_get_contents($filename);
        ob_end_flush();

        unlink($filename);

        exit;
    }

  }
  die("Echec du téléchargement");




?>
