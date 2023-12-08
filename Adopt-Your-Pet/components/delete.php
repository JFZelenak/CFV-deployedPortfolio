<?php
session_start();

if(!isset($_SESSION["adm"])){
    header("Location: home.php");
}

require_once "./db_connect.php" ;

function deleteItem($source, $connect){
    $id = $_GET["id"];

    if($source == "animal" || $source == "animalList"){
        $sql = "SELECT * FROM animal WHERE id = $id";
    } elseif($source == "user" || $source == "userList") {
        $sql = "SELECT * FROM user WHERE id = $id";
    } elseif($source == "adoptedList") {
        $sql = "SELECT * FROM pet_adopt WHERE id = $id";
    } else {
        $sql = "";
    }

    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);

    if($source == "animal" || $source == "animalList") {
        if ($row["image"] != "default_animal.jpg" && $row["image"] != "default_user.jpg") {
            unlink("../assets/$row[image]");
        }
        $delete = "DELETE FROM animal WHERE id = $id";
    } elseif ($source == "user" || $source == "userList") {
        if ($row["image"] != "default_user.jpg" && $row["image"] != "default_animal.jpg") {
            unlink("../assets/$row[image]");
        }
        $delete = "DELETE FROM user WHERE id = $id";
    } elseif ($source == "adoptedList") {
        $delete = "DELETE FROM pet_adopt WHERE id = $id";
    } else {
        $delete = "";
    }

    if(mysqli_query($connect, $delete)){
        $message = "Item deleted!";
    }else {
        $message = "Error! Item not deleted!";
    }
    echo "
        <div class='alert alert-warning'>
            <p class='w-100 text-center'>$message</p>
        </div>
        ";
    if($source == "animal") {
        header("refresh: 3; url= ../home.php");
    } elseif($source == "animalList") {
        header("refresh: 3; url= ../dashboard_animal_list.php");
    } elseif($source == "user") {
        header("refresh: 3; url= ../home.php");
    } elseif($source == "userList") {
        header("refresh: 3; url= ../dashboard_user_list.php");
    } elseif($source == "adoptedList") {
        header("refresh: 3; url= ../dashboard_adopted_list.php");
    }
}

if (isset($_GET['source'])) {
    $source = $_GET['source'];
    deleteItem($source, $connect);
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
