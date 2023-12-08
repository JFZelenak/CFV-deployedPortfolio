<?php
session_start();

if(!isset($_SESSION["user"])){
    header("Location: home.php");
}

require_once "./db_connect.php";

$source = $_GET["source"];
$user_id = $_SESSION["user"];
$pet_id = $_GET["id"];
$currentDate = date("Y-m-d");

$sql = "INSERT INTO `pet_adopt` (fk_user_id, fk_pet_id, adoption_date) VALUES ($user_id,$pet_id,'$currentDate')";

if(mysqli_query($connect, $sql)){
    $sql2 = "UPDATE animal SET
                status = 'not_available'
                WHERE id = $pet_id";
    $result2 = mysqli_query($connect, $sql2);
    echo "
        <div class='alert alert-success'>
            <p class='w-100 text-center'>You have just Adopted-Your-Pet! Congratulations!</p>
        </div>
        ";
}else {
    echo "
        <div class='alert alert-danger'>
            <p class='w-100 text-center'>Error! Something went wrong!</p>
        </div>
        ";
}

if($source == "one_click") {
    header("refresh: 3; url= ../details.php?source=adopt&id=$pet_id");
} elseif($source == "adoption") {
    header("refresh: 3; url= ../adoption.php");
}
mysqli_close($connect);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adopt-Your-Pet delete</title>
    <?php require_once "./_head-links.php"?>
</head>
<body>



</body>
</html>

