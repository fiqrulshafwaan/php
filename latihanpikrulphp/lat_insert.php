<?php
/* Attempt MySQL server connection */

$host = "localhost";
$user = "root";
$pass = "";
$database = "datasiswamtd";

$link = mysqli_connect($host, $user, $pass, $database);

// Check connection
if ($link === false) {
    die("Connection failed: " . mysqli_connect_error());
}

// Attempt select query execution
$sql = "SELECT * FROM mm3";

if ($result = mysqli_query($link, $sql)) {

    if (mysqli_num_rows($result) > 0) {

        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>NIS</th>";
        echo "<th>NAMA</th>";
        echo "<th>KELAMIN</th>";
        echo "<th>ALAMAT</th>";
        echo "<th>NO TELPON</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['NIS'] . "</td>";
            echo "<td>" . $row['NAMA'] . "</td>";
            echo "<td>" . $row['KELAMIN'] . "</td>";
            echo "<td>" . $row['ALAMAT'] . "</td>";
            echo "<td>" . $row['NOMERTELEPON'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Free result set
        mysqli_free_result($result);

    } else {
        echo "No records matching your query were found.";
    }

} else {
    echo "ERROR: Could not execute query. "
         . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>