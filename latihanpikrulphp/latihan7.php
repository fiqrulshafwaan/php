<?php
$hari=date("D");
switch ($hari) {

case "Mon":
    echo "senin" ;
    break;

case "Tues":
    echo "selasa" ;
    break;

case "Wed":
    echo " Rabu" ;
    break;
    default:
    echo "hari lain" ;
    }
    ?>