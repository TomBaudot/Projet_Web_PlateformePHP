<?php
require_once(ROOT_PATH.'/models/team_ranking.php');

class TeamRankingController
{

    public function __construct()
    {
    }

    public function displayTeamRanking()
    {
        $objet = new TeamRanking();
        $teamRanking = $objet->getTeamRanking();

        require_once(ROOT_PATH . '/views/team_ranking_table.php');

        echo '<div class="text-center">
        <a href="get_report_file.php" class="btn btn-success btn" lang="fr">Générer le rapport</a>
        <a href="get_report_file.php" class="btn btn-success btn" lang="eng">Generate a report</a>
        </div>';

    }
}
?>
