
<?php
// simpan lat_insert_valid.php

$conn = mysqli_connect("localhost", "root", "", "datapikrul");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil data dari form
$nama = $_POST['name'] ?? "";
$email = $_POST['email'] ?? "";
$website = $_POST['website'] ?? "";
$comment = $_POST['comment'] ?? "";
$gender = $_POST['gender'] ?? "";

// Upload file
$uploads_dir = "uploads";
$file = "";

if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {

    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
    $nm = basename($_FILES["fileToUpload"]["name"]);

    $file = uniqid() . "_" . $nm;

    $hasil = move_uploaded_file($tmp_name, $uploads_dir . "/" . $file);

    if (!$hasil) {
        die("File gagal diupload");
    }
}

// Memasukkan data ke database
$simdb = "INSERT INTO sija2 (nama, email, website, komen, gender, file)
          VALUES ('$nama', '$email', '$website', '$comment', '$gender', '$file')";

if (mysqli_query($conn, $simdb)) {
    echo "Data sudah tersimpan";
} else {
    echo "Data gagal disimpan: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
