<?php
session_start();

require_once "components/db_connect.php";

$sql = "SELECT * FROM animal" ;
$result = mysqli_query($connect, $sql);

$cards = "" ;

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        if(isset($_SESSION['adm'])){
            $update_btn = "<a href='dashboard_animal_update.php?source=animal&id={$row["id"]}' class='btn btn-outline-warning me-2'>Update</a>";
            $delete_btn = "<a href='components/delete.php?source=animal&id={$row["id"]}' class='btn btn-outline-danger'>Delete</a>";
        } else {
            $update_btn = "";
            $delete_btn = "";
        }
        $availT = $row["status"] == "available" ? "d-none" : " notAvailableText";
        $availI = $row["status"] == "available" ? "" : " notAvailableImg";
        $cards .= "
    <div>
        <div class='card m-2' style='width: 18rem;'>
            <img src='assets/{$row["image"]}' class='card-img-top p-relative $availI' alt='{$row["pet_name"]}'>
            <span class='$availT'>Adopted!</span>
            <div class='card-body'>
                <h5 class='card-title'>{$row["pet_name"]}</h5>
                <p class='card-text'>
                    {$row["type"]}, {$row["breed"]}<br>
                    ";
        $row["age"] != 1 ? $cards .= "age: {$row["age"]} years" : $cards .= "age: {$row["age"]} year";
        $cards .= "
        
                </p>
                <a href='details.php?source=animal&id={$row["id"]}' class='btn btn-outline-dark me-1'>Details</a>
                ". $update_btn . $delete_btn ."
            </div>
        </div>
    </div>";
    }
} else  {
    $cards = "<p>No results found</p>" ;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adopt-Your-Pet home</title>
    <?php require_once "components/_head-links.php"?>
</head>
<body>
<?php require_once "components/_navbar.php"?>
<?php require_once "components/_hero.php"?>

<div class="container">
    <h2 class="w-100 text-center">Our <span>Pets</span>:</h2>
    <div class="d-flex flex-wrap justify-content-center">
        <?= $cards ?>
    </div>
</div>

<?php require_once "components/_footer.php"?>
</body>
</html>
