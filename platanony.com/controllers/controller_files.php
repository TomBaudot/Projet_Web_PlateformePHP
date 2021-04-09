<?php
session_start();

if (isset($_SESSION['admin_name'])){

    if (isset($_GET['team_id']) && isset($_GET['filetype'])){

        require_once('../models/files.php');

        if ($_GET['filetype'] == "Ffile" && $_GET['team_id'] !== "displayText"){
            $myFile = new Files();

            $result = $myFile->get_F_files($_GET['team_id']);

            if ($result != null){
                define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

                foreach ($result as $row){

                    echo '<a href="get_F_files.php?filename=' . $row['name_correspondence'] . '">' . $row['name_correspondence'] . '</a>'. '<br/>';
                }
            }
            else{
                echo '<div>null</div>';
            }

        }

        else if ($_GET['filetype'] == "Afile" && $_GET['team_id'] !== "displayText"){
            $myFile = new Files();

            $result = $myFile->get_A_files($_GET['team_id']);


            if ($result != null){
                define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

		$i = 0;

		foreach ($result as $row){

			if (!$i){

                    		echo '<a href="get_A_files.php?filename=' . $row['name_attack'] . '">' . $row['name_attack'] . '</a>'. '<br/>|<p>'.$row['score_attack'].'</p>';
			}
			else{
				echo '|<a href="get_A_files.php?filename=' . $row['name_attack'] . '">' . $row['name_attack'] . '</a>' . '<br/>|<p>' . $row['score_attack'] . '</p>';
			}

			$i++;

                }
            }
            else{
                echo '<div>null</div>';
            }

        }

    }
}
