<div class="container">
  <div class="card text-center h3 text-white">
    <div class="card-header text-white">
      TEMPS RESTANTS
    </div>
    <div class="card-body">




    <?php

        date_default_timezone_set('Europe/Paris');

        /*$script_tz = date_default_timezone_get();

        if (strcmp($script_tz, ini_get('date.timezone'))){
            echo "Le fuseau horaire de l'application web diffère de celui sur ini-set.";
        }
        else {
            echo "Le fuseau horaire de l'application web et de celui sur ini-set correspondent.";
        }*/

        require_once(ROOT_PATH .'/diff_time.php');


        $today = date("H:i:s");

        $today = (string)$today;
        $val = $countdown['date'];
        $val= (string)$val;

        if(!empty($val)){
          $diff = diff_time($today,$val);
          //echo '<br> val bd : '.$val.'<br> val now : '.$today.'<br>val diff : '.$diff;

          echo "<div> <span style='font-size: xx-large;text-align: center'> Temps écoulé : ".$diff." </span></div>";
        }
        else{
          echo "<div> <span style='font-size: xx-large;text-align: center'> Temps écoulé : 00:00:00 </span></div>";
        }




    ?>
  </div>
</div>
