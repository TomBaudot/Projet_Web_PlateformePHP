<?php
    if($teamRanking != NULL && sizeof($teamRanking) > 0) {
        $rank = 1;

        echo('<div class="container">
            <table id="table-orange" class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">
                        #
                    </th>
                    <th scope="col">
                        <span lang="fr">Score d\'attaque</span>
                        <span lang="eng">Attack score</span>
                    </th>
                    <th scope="col">
                        <span lang="fr">Score de défense</span>
                        <span lang="eng">Defense score</span>
                    </th>
                    <th scope="col">
                        <span lang="fr">Nom de l\'équipe</span>
                        <span lang="eng">Team name</span>
                    </th>
                    </tr>
                </thead>
                <tbody>

            ');
        foreach ($teamRanking as $team) {

            echo ('
                    <tr>
                      <th scope="row">'.$rank.'</th>
                      <th scope="row">'.$team->attack_score_team.'</th>
                      <th scope="row">'.$team->defense_score_team.'</th>
                      <td>'. htmlspecialchars($team->name_team) .'</td>
                    </tr>
                  ');
            $rank += 1;
        }
        echo('
                </tbody>
           </table>
           </div>
           ');
    }


?>

<script>
    function test() {
        setInterval(function() {
            window.location.reload();
        }, 30000);
    }
    test();
</script>
