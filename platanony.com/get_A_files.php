<?php
  session_start();

  define('ROOT_PATH', realpath(dirname(__FILE__)));

  // Si on a une session
  if(isset($_SESSION['admin_name']) && isset($_SESSION['admin_password'])){

    // Si on a reçu un nom de fichier en GET et qu'il existe alors on le télécharge
    if(isset($_GET['filename']) && file_exists(ROOT_PATH . '/attack/' . $_GET['filename'])){

      $filename = ROOT_PATH . '/attack/' . $_GET['filename'];
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . $_GET['filename']);
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
  die("Echec du téléchargement");





?>
