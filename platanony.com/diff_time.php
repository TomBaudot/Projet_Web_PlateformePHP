<?php
function diff_time($t1 , $t2){
    //Heures au format (hh:mm:ss) la plus grande puis le plus petite

    $tab=explode(":", $t1);
    $tab2=explode(":", $t2);

    $h=$tab[0];
    $m=$tab[1];
    $s=$tab[2];
    $h2=$tab2[0];
    $m2=$tab2[1];
    $s2=$tab2[2];

    if ($h2>$h) {
        $h=$h+24;
    }
    if ($m2>$m) {
        $m=$m+60;
        $h2++;
    }
    if ($s2>$s) {
        $s=$s+60;
        $m2++;
    }

    $ht=$h-$h2;
    $mt=$m-$m2;
    $st=$s-$s2;
    if (strlen($ht)==1) {
        $ht="0".$ht;
    }
    if (strlen($mt)==1) {
        $mt="0".$mt;
    }
    if (strlen($st)==1) {
        $st="0".$st;
    }
    return $ht.":".$mt.":".$st;

}
?>
