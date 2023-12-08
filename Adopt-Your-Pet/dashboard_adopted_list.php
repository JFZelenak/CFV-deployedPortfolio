<?php
session_start();

if(!isset($_SESSION["adm"])){
    header("Location: home.php");
}

require_once "components/db_connect.php";

$sql2 = "SELECT
    pa.id AS pa_id, adoption_date,fk_user_id,
    first_name, last_name, u.image AS u_image,
    fk_pet_id, pet_name, a.image AS a_image
    FROM pet_adopt AS pa
    JOIN animal AS a ON a.id = pa.fk_pet_id
    JOIN user AS u ON u.id = pa.fk_user_id";
$result2 = mysqli_query($connect, $sql2);

$tableRows = "" ;

if(mysqli_num_rows($result2) > 0){
    while($row2 = mysqli_fetch_assoc($result2)){
        $tableRows .= "
            <tr>
                <td>{$row2["pa_id"]}</td>
                <td>{$row2["adoption_date"]}</td>
                <td>{$row2["fk_user_id"]}</td>
                <td>{$row2["first_name"]} {$row2["last_name"]}</td>
                <td><img src='assets/{$row2["u_image"]}' alt='missing image' height='32px'></td>
                <td>{$row2["fk_pet_id"]}</td>
                <td>{$row2["pet_name"]}</td>
                <td><img src='assets/{$row2["a_image"]}' alt='missing image' height='32px'></td>
                <td><a href='components/delete.php?source=adoptedList&id={$row2["pa_id"]}' class='btn btn-outline-danger'>Delete</a></td>
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
        <a href="dashboard_animal_list.php" class="nav-link pe-5">Animal list</a>
        <a href="dashboard_user_list.php" class="nav-link pe-5">User list</a>
        <a href="dashboard_adopted_list.php" class="nav-link fw-bold">Adopted list</a>
    </div>
    <hr class="mt-0">
    <div class="card p-3">
        <h5>Animal list:</h5>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Adoption ID</th>
                    <th>Adoption date</th>
                    <th>User ID</th>
                    <th>User name</th>
                    <th>User image</th>
                    <th>Pet ID</th>
                    <th>Pet name</th>
                    <th>Pet image</th>
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
