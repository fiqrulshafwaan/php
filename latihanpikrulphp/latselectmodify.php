<table border="1">
<tr>
    <th>no</th>
    <th>nama</th>
    <th>email</th>
    <th>website</th>
    <th>komen</th>
    <th>gender</th>
    <th>file</th>
    <th>modify</th>
</tr>

<?php
$conn = mysqli_connect("localhost", "root", "", "datapikrul");

$database = "select * from sija2";

$datres = mysqli_query($conn, $database);

if ( $datres=mysqli_query($conn,$database)) {
if (mysqli_num_rows($datres)) {

while ($datarr = mysqli_fetch_array($datres)) {

    echo "<tr>
        <td> $datarr[0] </td>
        <td> $datarr[1] </td>
        <td> $datarr[2] </td>
        <td> $datarr[3] </td>
        <td> $datarr[4] </td>
        <td> $datarr[5] </td>
      <td><img src='uploads/" . $datarr[6] . "' width='50' height='50'></td>

        <td> <a href='latdelete.php?pilno=" . $datarr[0] . "'> delete </td>
     </tr>";
    }
} else {
    echo "data baris kosong" ;
}

}
else {
    echo "data base dan conection error" ;
}

?>

</table>