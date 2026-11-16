<?php
$nilaiA=8 ;
$nilaiB=8 ;

$rata= ($nilaiA+$nilaiB) /2;
if ($rata > 8){
    echo "sangat baik" ;

}
else if ($rata > 7) {
    echo "baik";

}
else if ($rata > 6) {
    echo " cukup ";
}
else { echo " kurang "; }
?>