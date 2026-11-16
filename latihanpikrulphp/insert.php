<?php
$conn = mysqli_connect("localhost", "root", "", "datapikrul");

echo $_GET['nama'].$_GET['email'].$_GET['website'].$_GET['komen'].$_GET['gender']
        

$simdb="insert into sija2 (nama,email,website,komen,gender)
        values('$_GET[nama]','$_GET[email]','$_GET[website]',
        '$_GET[komen]','$_GET[gender]')";

if ($simqr=mysqli_query($conn,$simdb)) {
    echo "data sudah di simpan";
}else{
    echo "data tidak tersimpan";
}


?>