<?php
  session_start();

  define('ROOT_PATH', realpath(dirname(__FILE__)));

  $ground_truth_name = "org_data.csv";

  $is_logged = false;

  // Si on a une session
  if((isset($_SESSION['admin_name']) && isset($_SESSION['admin_password'])) || (isset($_SESSION['team_name']) && isset($_SESSION['password']))){
    $is_logged = true;
  }

  if ($is_logged){

    // Si on a reçu un nom de fichier en GET et qu'il existe alors on le télécharge
    if(file_exists(ROOT_PATH . '/uploads/' . $ground_truth_name)){

      $filename = ROOT_PATH . '/uploads/' . $ground_truth_name;
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . $ground_truth_name . '"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($filename));

      $myInputStream = fopen($filename, 'rb');
      $myOutputStream = fopen('php://output', 'wb');

      stream_copy_to_stream($myInputStream, $myOutputStream);

      fclose($myOutputStream);
      fclose($myInputStream);

      exit;
    }


  }
  die("Erreur téléchargement du fichier ground truth");







?>
