
<?php
$nama = $email = "";
$namaErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nama"])) {
        $namaErr = "nama belum diisi";
    } else {
        $nama = $_POST["nama"];
    }

    $email = $_POST["email"] ?? "";
}
?>

<form method="POST" action="latinsertvalid.php">
    nama:
    <input type="text" name="nama">
    <?php echo $namaErr; ?>
    <span class="error">*</span>

    <br><br>

    email:
    <input type="text" name="email">
    <span class="error">*</span>

    <br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Your Input:</h2>";
    echo $nama;
    echo "<br>";
    echo $email;
    echo "<br>";
    

    if (empty($namaErr)) {
        include 'lat_insert_valid.php';
    }
}
?>
