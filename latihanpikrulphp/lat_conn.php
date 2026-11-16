<?php
/* Attempt MySQL server connection */

$host = "localhost";
$user = "root";
$pass = "";
$database = "datapikrul";

$link = mysqli_connect($host, $user, $pass, $database);

// Check connection
if ($link === false) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";
?>