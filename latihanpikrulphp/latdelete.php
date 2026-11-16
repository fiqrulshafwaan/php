
<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "datapikrul";

$link = mysqli_connect($host, $user, $pass, $database);

if (!$link) {
    die("ERROR: " . mysqli_connect_error());
}

if (isset($_GET['pilno'])) {

    $pilno = mysqli_real_escape_string($link, $_GET['pilno']);

    $sql = "DELETE FROM sija2 WHERE no='$pilno'";

    if (mysqli_query($link, $sql)) {
        echo "Nice! Data Berhasil Dihapus";
    } else {
        echo "ERROR: " . mysqli_error($link);
    }

} else {
    echo "Nomor data tidak ditemukan";
}

mysqli_close($link);
?>
