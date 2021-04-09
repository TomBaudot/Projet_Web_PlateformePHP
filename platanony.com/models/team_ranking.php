<!-- Distribution model -->

<?php
class TeamRanking {

    public $name_team;
    public $score_team;

    public function __construct($name_team = false, $attack_score_team = false, $defense_score_team = false) {
        if ($name_team === false) return;

        $this->name_team = $name_team;
        $this->attack_score_team = $attack_score_team;
        $this->defense_score_team = $defense_score_team;
    } //end construct

    public function getTeamRanking() {
        try {
            global $con;
            $sql = "SELECT name_team, attack_score_team, defense_score_team, (attack_score_team + defense_score_team)/2 as moyenne FROM team ORDER BY moyenne desc";
            $reponse = $con->query($sql);

            foreach ($reponse as $soumis) {
                $list[] = new TeamRanking($soumis['name_team'], $soumis['attack_score_team'], $soumis['defense_score_team']);
            }

            if (isset($list)) {
                return $list;
            }

            return NULL;


        } catch (PDOException $e) {
            echo $sql . "</br>" . $e->getMessage();
        }
    }
}