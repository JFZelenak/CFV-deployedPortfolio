<?php
session_start();

if(!isset($_SESSION["adm"])){
    header("Location: home.php");
}

require_once "components/db_connect.php";

$sql2 = "SELECT * FROM animal";
$result2 = mysqli_query($connect, $sql2);

$tableRows = "" ;

if(mysqli_num_rows($result2) > 0){
    while($row2 = mysqli_fetch_assoc($result2)){
        $tableRows .= "
            <tr>
                <td>{$row2["id"]}</td>
                <td>{$row2["pet_name"]}</td>
                <td>{$row2["type"]}</td>
                <td>{$row2["breed"]}</td>
                <td>{$row2["vaccinated"]}</td>
                <td>{$row2["status"]}</td>
                <td><img src='assets/{$row2["image"]}' alt='missing image' height='32px'></td>
                <td><a href='details.php?source=animalList&id={$row2["id"]}' class='btn btn-outline-dark'>Details</a></td>
                <td><a href='dashboard_animal_update.php?source=animalList&id={$row2["id"]}' class='btn btn-outline-warning'>Update</a></td>
                <td><a href='components/delete.php?source=animalList&id={$row2["id"]}' class='btn btn-outline-danger'>Delete</a></td>
            </tr>
            ";
    }
} else  {
    $tableRows = "<p>No results found</p>" ;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adopt-Your-Pet dashboard</title>
    <?php require_once "components/_head-links.php"?>
</head>
<body>
<?php require_once "components/_navbar.php"?>
<?php require_once "components/_hero.php"?>

<div class="container">
    <h2 class="w-100 text-center mt-2">Admin dashboard:</h2>
    <hr class="mb-0">
    <div class="d-flex justify-content-center bg-body-tertiary py-3">
        <a href="dashboard.php" class="nav-link pe-5">Add animal</a>
        <a href="dashboard_animal_list.php" class="nav-link fw-bold pe-5">Animal list</a>
        <a href="dashboard_user_list.php" class="nav-link pe-5">User list</a>
        <a href="dashboard_adopted_list.php" class="nav-link">Adopted list</a>
    </div>
    <hr class="mt-0">
    <div class="card p-3">
        <h5>Animal list:</h5>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet name</th>
                    <th>Type</th>
                    <th>Breed</th>
                    <th>Vaccinated</th>
                    <th>Availability</th>
                    <th>Image</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?= $tableRows ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "components/_footer.php"?>
</body>
</html>
