<!-- Page content -->
<?php
  if(isset($n_sub) && isset($max_n_sub) && ($n_sub < $max_n_sub))
  {
?>
<h1 class="p-5 text-center text-white">
    <span lang="eng">Upload a submission</span>
    <span lang="fr">Télécharger une soumission</span>
</h1>

    <form class="text-center" method="POST" action="<?php ROOT_PATH ?>validationUpload.php" enctype="multipart/form-data">
        <!-- On limite le fichier à 100Ko -->
        <input type="hidden" class ="form-control-file" name="MAX_FILE_SIZE" value="1000000000000000">
        <span class="h3 text-white" lang="eng">File : </span>
        <span class="h3 text-white" lang="fr">Fichier : </span>

        <input class="text-white" id="browse_submission_btn" type="file" name="soumission" required>
        <br \>
        <input id="valid_submission" type="submit" class="btn m-5 btn-warning" name="envoyer" value="Envoyer le fichier">

        <script>
            if (readCookie("lang") === "eng"){
                $('#valid_submission').attr('value', "Upload");
            }
        </script>

    </form>
    <?php
    }
    else{
    ?>
    <div class="alert alert-warning text-center w-50 mx-auto" role="alert" style="border-radius: 10px;">
      <span lang="eng">You have already uploaded 3 files.</span>
      <span lang="fr">Vous avez déjà envoyé 3 fichiers.</span>
    </div>
    <?php
    }
    ?>




    <div class="row justify-content-md-center">
    <?php

    if($fileAlreadySaved != NULL && sizeof($fileAlreadySaved)>0)
    {

        foreach ($fileAlreadySaved as $file) {
          $score_defense_fr = "En cours de calcul";
          $score_defense_eng = "Processing";

          $score_utility_fr = "En cours de calcul";
          $score_utility_eng = "Processing";

          if ($file->score_utility != -1){
            $score_defense_fr = $file->score_defense;
            $score_defense_eng = $file->score_defense;

            $score_utility_fr = $file->score_utility;
            $score_utility_eng = $file->score_utility;

          }

            echo ('
                        <div class="card m-5" style="width: 18%;">
                            <img src="https://deepakrip007.files.wordpress.com/2013/12/csv.png?w=300&h=300" class="card-img-top">
                            <div class="card-body text-white">
                                <h5 lang="fr" class="card-title"><u>Nom du fichier :</u> '.$file->name.'</h5>
                                <h5 lang="eng" class="card-title"><u>File\'s name :</u> '.$file->name.'</h5>
                                <p lang="fr" style="font-size: 80%;"><u>Score d\'utilité :</u> '.$score_utility_fr.'</p>
                                <p lang="eng" style="font-size: 80%;"><u>Utility score :</u> '.$score_utility_eng.'</p>
                                <p lang="fr" style="font-size: 80%;"><u>Score de défense :</u> '.$score_defense_fr.'</p>
                                <p lang="eng" style="font-size: 80%;"><u>Defense score :</u> '.$score_defense_eng.'</p>
                                <p lang="fr" style="font-size: 80%;"><u>Date d\'envoi :</u> '.$file->date_submission.'</p>
                                <p lang="eng" style="font-size: 80%;"><u>Date of upload :</u> '.$file->date_submission.'</p>
                        </div>
                        </div>
                        ');


        }


    }


    ?>

  </div>


<!-- // Page content -->
