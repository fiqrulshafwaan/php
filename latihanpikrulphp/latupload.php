<?php

    $tmp_name = $_FILES["fileToUpload"]["tmp_name"];

    $nm = basename($_FILES["fileToUpload"]["name"] );

echo  $tmp_name;."<br>";
echo  $nm;

?>