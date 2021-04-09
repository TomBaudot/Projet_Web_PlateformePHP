

<h1 class="p-5 text-white text-center">
    <span lang="eng">Manage each team</span>
    <span lang="fr">Gérer les équipes</span>

</h1>

    <form class="p-2 text-white text-center" method="POST" action="<?php ROOT_PATH ?>index.php?controller=manage&action=uploadTeam">
        <span lang="eng">New Team</span>
        <span lang="fr">Nouvelle Équipe</span></br>
        <br \>
        <span lang="eng">Team's name</span>
        <span lang="fr">Nom de l'équipe :</span>
         <input type="text" name="team_name">

        <span lang="eng">Password</span>
        <span lang="fr">Mot de passe :</span>

        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." required>
        <input id="manage_team_sub_btn" type="submit" class="btn btn-warning" name="envoyer" value="Ajouter une équipe">
    </form>

    <?php
    if($teams != NULL)
    {
      foreach($teams as $team)
      {
        $score = ($team->score_team + $team->defense_score_team)/2;
        echo'<div class="card m-5">
              <h5 style="color:#FF8C00 ; background-color:#000" class="text-center card-header">'.$team->id_team.'|'. htmlspecialchars($team->team_name) .'</h5>
              <div class="text-center bg-dark card-body">
                <h5 style="color:orange" class="card-title">Score</h5>
                <p style="color:orange" class="card-text">'.$score.'</p>
                <form class="p-2 text-white text-center" method="POST" action="index.php?controller=manage&action=changeScore&id_team='.$team->id_team.'">
                    <span lang="eng">Defence score</span>
                    <span lang="fr">Score de défense</span>
                    <input type="text" name="scoreDefense" value="'.$team->defense_score_team.'">
                    <span lang="eng">Attack score</span>
                    <span lang="fr">Score d\'attaque</span>
                    <input type="text" name="scoreAttaque" value="'.$team->score_team.'">
                    <input type="submit" class="btn m-5 btn-info" name="Modifier" value="Modifier score">
                </form>
                <a href="index.php?controller=manage&action=deleteTeam&id_team='.$team->id_team.'" class="btn btn-danger">
                    <span lang="eng">Remove the team</span>
                    <span lang="fr">Supprimer l\'équipe</span>
                </a>
              </div>
            </div>';
      }
    }

    ?>
    <script>
        if (readCookie("lang") === "eng"){
            $('#manage_team_sub_btn').attr('value', "Upload");
        }
    </script>
