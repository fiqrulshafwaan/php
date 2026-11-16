<?php
$conn = mysqli_connect("localhost", "root", "", "datapikrul");
$databaca = "select *from sija2";
$datares=mysqli_query($conn,$databaca);

        $datarow = mysqli_fetch_array($datares);

            echo $datarow[0];
            echo $datarow["nama"];
            echo $datarow[2];
            echo $datarow[3];
            echo $datarow[4];
            echo $datarow[5]; 



?>