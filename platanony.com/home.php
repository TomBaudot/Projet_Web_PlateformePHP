<?php
  if(isset($is_logged) && $is_logged)
    {
?>
    <a href="get_Ground_Truth.php" class="list-group-item list-group-item-action">
          <span lang="eng">Download the file Ground Truth</span><span lang="fr">Télécharger le fichier Ground Truth</span>

    </a>

<?php
}
?>


    <br/>
    <h1 class="text-white text-center">
        <span lang="eng">The latest tickets : </span><span lang="fr">Les derniers tickets : </span>
    </h1>
<?php

    if($ticketsAlreadySaved != NULL && sizeof($ticketsAlreadySaved) > 0) {
        foreach ($ticketsAlreadySaved as $ticket) {
            echo ('
                        <div class="card m-5">
                        <h2 style="color:#FF8C00 ; background-color:#000" class="text-center card-header">
                        '.$ticket->title.'
                        </h2>
                        <div class="text-center bg-dark card-body">
                        <h4 style="color:orange" class="card-title pt-5">'.$ticket->data.' </h4>
                        <h6 style="color:orange" class="card-text pt-5">'.$ticket->date.'</h6>
                        </div>
                        </div>
                ');

        }
    }

?>
