<?php   define('ROOT_PATH', realpath(dirname(__FILE__)));
    define("UPLOAD_REP", __DIR__ ."/attack/");
    define("UPLOAD_SIZEMAX", 1000000000000000); // La taille, en octets.
    define("UPLOAD_EXTENSION", "json");
    define("UPLOAD_MIMETYPE", "text/plain");

    if (!empty($_POST)) {

        // Messages d'erreurs de chargement de fichiers
        $array_upload_err = [
            // UPLOAD_ERR_OK => "Valeur : 0. Aucune erreur, le téléchargement est correct.",
            UPLOAD_ERR_INI_SIZE => "Valeur : 1. La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini.",
            UPLOAD_ERR_FORM_SIZE => "Valeur : 2. La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.",
            UPLOAD_ERR_PARTIAL => "Valeur : 3. Le fichier n'a été que partiellement téléchargé.",
            UPLOAD_ERR_NO_FILE => "Valeur : 4. Aucun fichier n'a été téléchargé.",
            UPLOAD_ERR_NO_TMP_DIR => "Valeur : 6. Un dossier temporaire est manquant. Introduit en PHP 5.0.3.",
            UPLOAD_ERR_CANT_WRITE => "Valeur : 7. Échec de l'écriture du fichier sur le disque. Introduit en PHP 5.1.0.",
            UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté l'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause.",
        ];

        $errors = array();

        if ($_FILES['soumission']['error'] != 0)
        {
            $errors['upload_err'] = $array_upload_err[$_FILES['soumission']['error']];
        } else {
            // Récupère l'extension d'un fichier
            $spl_file_info = new SplFileInfo($_FILES['soumission']['name']);
            $file_Extension = strtolower($spl_file_info->getExtension());

            // Retourne le type mime à l'extension mimetype
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            /* Récupère le mime-type d'un fichier spécifique */
            $file_MimeType = $finfo->file($_FILES['soumission']['tmp_name']);



            // On vérifie la taille, en octets, du fichier téléchargé
            if ($_FILES['soumission']['size'] > UPLOAD_SIZEMAX) {
                header("Location:index.php?controller=attack&action=print_error&error=size");
                $errors['size'] = 'Taille de fichier supérieure à la taille maximum autorisée';
            }

            // On vérifie l'extension
            if (!in_array($file_Extension, explode(',', constant('UPLOAD_EXTENSION'))))
            {
                header("Location:index.php?controller=attack&action=print_error&error=extension");
                $errors['ext'] = 'L\'extension ne correspond pas aux extensions acceptées';
            }

            // On vérifie le type mime
            if ($file_MimeType != UPLOAD_MIMETYPE && $file_MimeType != "application/json")
            {
		    header("Location:index.php?controller=attack&action=print_error&error=mime");
		    $errors['ext'] = 'L\'extension ne correspond pas aux extensions acceptées 2';
            }

            if(!isset($_GET['id_team'])){
              header("Location:index.php?controller=attack&action=print_error&error=unknown");
            }

            if (empty($errors))
            {
                $key = sha1($_FILES['soumission']['name']) . '.' . $file_Extension;

                if(!file_exists(UPLOAD_REP . $key)){

                  if (move_uploaded_file($_FILES['soumission']['tmp_name'], UPLOAD_REP . $key)) {
                      $_SESSION['flash']['success'] = 'Upload effectué avec succès !';
                      header("Location:index.php?controller=attack&action=upload&id=0&nom_fichier=".$key."&id_team=" . $_GET['id_team'] . "&id_soumission=".$_GET['id_soumission']);

                  } else {

                      header("Location:index.php?controller=attack&action=print_error&error=unknown");

                  }

                }
                else{
                  header("Location:index.php?controller=attack&action=print_error&error=file_exists");
                }
            }
            else {
                foreach ($errors as $error)
                {

                    echo('<div class="alert alert-danger" role="alert">
            '.$error.'
            </div>');
                }

            }
        }
    }

    ?>

<!-- // footer -->
