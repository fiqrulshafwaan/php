<?php
$conn = mysqli_connect("localhost", "root", "", "datapikrul");
$databaca = "select *from sija2";
$datares=mysqli_query($conn,$databaca);
if (!$datres) {
    die("connection failed:")
}