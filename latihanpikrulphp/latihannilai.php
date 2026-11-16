<?php
// LAtihan6.php

if (isset ($_GET['fname'] ) and isset ( $_GET['lname'] ) ) {
    $nilaiA = $_GET['fname'] ;
    $nilaiB = $_GET['lname'] ;

    $rata = ( $nilaiA + $nilaiB ) / 2 ;
    //cek hasilnya
    
    //percabangan bertingkat
    if ($rata >= 8 ) {
        echo "Sangat Baik" ;
    }
    else if ($rata >= 7 ) {
        echo " Baik" ;
    } else if ($rata >= 6 ) {
        echo " cukup" ;
    }
    else {
        echo " kurang" ;
    }
} else {
    echo " data belum di isi " ;
}
?>