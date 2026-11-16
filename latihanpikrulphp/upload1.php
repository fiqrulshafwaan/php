
<?php
$uploads_dir = "uploads";

echo $_FILES['fileToUpload']['name'];

$tmp_name = $_FILES["fileToUpload"]["tmp_name"];

$name = basename($_FILES["fileToUpload"]["name"]);

echo "<br>";
echo $tmp_name . "<br>";
echo $name;

move_uploaded_file($tmp_name, $uploads_dir . "/" . $name);

?>
