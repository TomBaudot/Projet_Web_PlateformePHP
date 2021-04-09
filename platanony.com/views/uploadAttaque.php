    <?php
      if(isset($n_attack) && isset($max_n_attack) && ($n_attack < $max_n_attack))
      {
    ?>

        <h1 class="p-5 text-white text-center">
            <span lang="eng">Upload an attack</span>
            <span lang="fr">Télécharger une attaque</span>
        </h1>

        <form method="POST" class="text-center" action="<?php ROOT_PATH ?>validationUploadAtk.php?id_team=<?php echo($_GET['id_team'])?>&id_soumission=<?php echo($_GET['id_soumission'])?>" enctype="multipart/form-data">

            <!-- On limite le fichier à 100Ko -->
            <input type="hidden" class ="form-control-file" name="MAX_FILE_SIZE" value="1000000000000000">

            <span class="h3 text-white" lang="eng">File : </span>
            <span class="h3 text-white" lang="fr">Fichier : </span>

            <input class="text-white" id="browse_attack_btn" type="file" name="soumission" required>
            <br \>
            <input id="valid_attack" type="submit" class="btn m-5 btn-warning" name="envoyer" value="Envoyer le fichier">
            <script>
                if (readCookie("lang") === "eng"){
                    $('#valid_attack').attr('value', "Upload");
                }
            </script>
        </form>

    <?php
    }
    else{
    ?>
    <div class="alert alert-warning text-center w-50 mx-auto" role="alert" style="border-radius: 10px;">
      <span lang="eng">You have already uploaded 3 files for this submission.</span>
      <span lang="fr">Vous avez déjà envoyé 3 fichiers pour cette soumission.</span>
    </div>
    <?php
    }
    ?>


    <div class="row justify-content-md-center">

    <?php
    if($fileAlreadySaved != NULL && sizeof($fileAlreadySaved)>0)
    {

        foreach ($fileAlreadySaved as $file) {

          $score_fr = "En cours de calcul";
          $score_eng = "Processing";

          if ($file->score != -1){
            $score_fr = $file->score;
            $score_eng = $file->score;
          }

            echo ('
                        <div class="card m-5" style="width: 18%;">
                            <img src="../static/images/json_icon.png" class="card-img-top">
                            <div class="card-body text-white">
                                <h5 lang="fr" class="card-title"><u>Nom du fichier :</u> '.$file->name.'</h5>
                                <h5 lang="eng" class="card-title"><u>File\'s name :</u> '.$file->name.'</h5>
                                <p lang="fr" style="font-size: 80%;"><u>Score d\'attaque :</u> '.$score_fr.'</p>
                                <p lang="eng" style="font-size: 80%;"><u>Attack score :</u> '.$score_eng.'</p>
                                <p lang="fr" style="font-size: 80%;"><u>Date d\'envoi :</u> '.$file->date_attack.'</p>
                                <p lang="eng" style="font-size: 80%;"><u>Date of upload :</u> '.$file->date_attack.'</p>
                                <div class="text-center">
                                  <a href="index.php?controller=attack&action=delete&nom_fichier='.$file->name.'" class="btn btn-primary" lang="fr">Supprimer l\'attaque</a>
                                  <a href="index.php?controller=attack&action=delete&nom_fichier='.$file->name.'" class="btn btn-primary" lang="eng">Delete the attack</a>
                        </div>
                        </div>
                        </div>
                        ');

        }


    }

    ?>

    </div>
