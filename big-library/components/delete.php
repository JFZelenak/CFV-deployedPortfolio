<?php
require_once "db_connect.php";

$id=$_GET["id"];
$sql = "SELECT * FROM media WHERE id = '$id'";
$result = mysqli_query($connect,$sql);
$row = mysqli_fetch_assoc($result);
if($row["image"] != "default.jpg"){
    unlink("../assets/$row[image]");
}
$delete = "DELETE FROM media WHERE id= '$id'";
if(mysqli_query($connect, $delete)){
    header("location: ../index.php");
} else {
    echo "error";
}
mysqli_query($connect);