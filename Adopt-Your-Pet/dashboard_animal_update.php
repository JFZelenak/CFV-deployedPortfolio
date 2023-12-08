<?php
session_start();

if(!isset($_SESSION["adm"])){
    header("Location: home.php");
}

require_once "components/db_connect.php";
require_once "components/file_upload.php";
require_once "components/clean.php";

$error = false;
$pet_name_error = $type_error = $breed_error = $description_error = $size_error = $age_error = $vaccinated_error = $address_error = "";
$id = $_GET["id"];
$source = $_GET["source"];

$sql2 = "SELECT * FROM animal WHERE id = '$id'";
$result2 = mysqli_query($connect, $sql2);
$row2 = mysqli_fetch_assoc($result2);

$sql4 = "SELECT * FROM pet_adopt WHERE fk_pet_id = '$id'";
$result4 = mysqli_query($connect, $sql4);
$row4 = mysqli_fetch_assoc($result4);

if(isset($_POST["update_animal"])) {
    $pet_name = cleanInputs($_POST["pet_name"]);
    $type = cleanInputs($_POST["type"]);
    $breed = cleanInputs($_POST["breed"]);
    $description = cleanInputs($_POST["description"]);
    $size = cleanInputs($_POST["size"]);
    $age = cleanInputs($_POST["age"]);
    $vaccinated = $_POST["vaccinated"];
    $address = cleanInputs($_POST["address"]);
    $image = fileUpload($_FILES["image"], "animalList");

    $sameValidation = array($pet_name,$type,$breed,$description,$address);
    foreach ($sameValidation as $key=>$item){
        if(empty($item)){
            $error = true;
            $sameMessage = "Please, enter ";
            if($key==0) {
                $pet_name_error = $sameMessage . "pet name.";
            } elseif($key==1){
                $type_error = $sameMessage . "type.";
            } elseif($key==2){
                $breed_error = $sameMessage . "breed.";
            } elseif($key==3){
                $description_error = $sameMessage . "description.";
            } elseif($key==4){
                $address_error = $sameMessage . "address.";
            }
        } elseif(strlen($item) < 3){
            $error = true;
            $sameMessage = "Must have at least 3 characters.";
            if($key==0) {
                $pet_name_error = $sameMessage;
            } elseif($key==1){
                $type_error = $sameMessage;
            } elseif($key==2){
                $breed_error = $sameMessage;
            } elseif($key==3){
                $description_error = $sameMessage;
            } elseif($key==4){
                $address_error = $sameMessage;
            }
        } elseif(!preg_match( "/^[a-zA-Z0-9\s\/.,]+$/" , $item)){
            $error = true;
            $sameMessage = "Must contain only letters, numbers, slashes, dot, comma and spaces.";
            if($key==0) {
                $pet_name_error = $sameMessage;
            } elseif($key==1){
                $type_error = $sameMessage;
            } elseif($key==2){
                $breed_error = $sameMessage;
            } elseif($key==3){
                $description_error = $sameMessage;
            } elseif($key==4){
                $address_error = $sameMessage;
            }
        }
    }

    if (empty($age)) {
        $error = true ;
        $age_error = "Age can't be empty!" ;
    } elseif (!preg_match( "/^[0-9]+$/" , $age)) {
        $error = true;
        $age_error = "Age can only contain numbers.";
    }

    if($_FILES["image"]["error"] == 0 && !$error) {
        if ($row2["image"] != "default_animal.jpg" && $row2["image"] != "default_user.jpg") {
            unlink("../assets/$row2[image]");
        }
        $sql3 = "UPDATE animal SET
                pet_name = '$pet_name',
                type = '$type',
                breed = '$breed',
                description = '$description',
                size = '$size',
                age = '$age',
                vaccinated = '$vaccinated',
                address = '$address',
                image = '$image[0]'
                WHERE id = '$id'";
    } elseif(!$error) {
        $sql3 = "UPDATE animal SET
                pet_name = '$pet_name',
                type = '$type',
                breed = '$breed',
                description = '$description',
                size = '$size',
                age = '$age',
                vaccinated = '$vaccinated',
                address = '$address'
                WHERE id = '$id'";
    }

    if(mysqli_query($connect, $sql3)){
        echo "
            <div class='alert alert-success'>
                <p class='w-100 text-center'>
                    Animal updated.
                </p>
            </div>
            ";
        if($source == "animalList") {
            header("refresh: 3; url=dashboard_animal_list.php");
        } else {
            header("refresh: 3; url=home.php");
        }
    } else {
        echo "
            <div class='alert alert-danger'>
                <p class='w-100 text-center'>
                    Something went wrong! Try again please.
                </p>
            </div>
            ";
    }
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
        <a href="dashboard.php" class="nav-link pe-5">Add Animal</a>
        <a href="dashboard_animal_list.php" class="nav-link pe-5">Animal List</a>
        <a href="dashboard_user_list.php" class="nav-link pe-5">User List</a>
        <a href="dashboard_adopted_list.php" class="nav-link">Adopted list</a>
    </div>
    <hr class="mt-0">
    <div class="card p-3">
        <h5>Update <?= $row2['type'] ?> "<?= $row2['pet_name'] ?>":</h5>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <div class="d-flex">
                <div class="w-25 p-2">
                    <label for="pet_name">pet name:</label>
                    <input type="text" name="pet_name" id="pet_name" class="form-control" value="<?= $row2['pet_name'] ?>">
                    <span class="text-danger"><?= $pet_name_error ?></span>
                </div>
                <div class="w-25 p-2">
                    <label for="type">type:</label>
                    <input type="text" name="type" id="type" class="form-control" value="<?=  $row2['type'] ?>">
                    <span class="text-danger"><?= $type_error ?></span>
                </div>
                <div class="w-25 p-2">
                    <label for="breed">breed:</label>
                    <input type="text" name="breed" id="breed" class="form-control" value="<?= $row2['breed'] ?>">
                    <span class="text-danger"><?= $breed_error ?></span>
                </div>
                <div class="w-25 p-2">
                    <label for="vaccinated">vaccination status:</label>
                    <select name="vaccinated" id="vaccinated" class="form-control">
                        <option value="vaccinated" <?php echo ($row2['vaccinated'] == "vaccinated") ? "selected" : ""; ?> >vaccinated</option>
                        <option value="not_vaccinated" <?php echo ($row2['vaccinated'] == "not_vaccinated") ? "selected" : ""; ?> >not vaccinated</option>
                    </select>
                </div>
            </div>
            <div class="d-flex">
                <div class="w-50 p-2">
                    <label for="address">address:</label>
                    <input type="text" name="address" id="address" class="form-control" value="<?= $row2['address'] ?>">
                    <span class="text-danger"><?= $address_error ?></span>
                </div>
                <div class="w-25 p-2">
                    <label for="age">age:</label>
                    <input type="number" name="age" id="age" class="form-control" value="<?= $row2['age'] ?>">
                    <span class="text-danger"><?= $age_error ?></span>
                </div>
                <div class="w-25 p-2">
                    <label for="size">size:</label>
                    <select name="size" id="size" class="form-control">
                        <option value="xs" <?php echo ($row2['size'] == "xs") ? "selected" : ""; ?> >extra small</option>
                        <option value="sm" <?php echo ($row2['size'] == "sm") ? "selected" : ""; ?> >small</option>
                        <option value="md" <?php echo ($row2['size'] == "md") ? "selected" : ""; ?> >medium</option>
                        <option value="lg" <?php echo ($row2['size'] == "lg") ? "selected" : ""; ?> >large</option>
                        <option value="xl" <?php echo ($row2['size'] == "xl") ? "selected" : ""; ?> >extra large</option>
                    </select>
                </div>
            </div>
            <div class="d-flex">
                <div class="w-50 p-2">
                    <label for="description">description:</label>
                    <input type="text" name="description" id="description" class="form-control" value="<?= $row2['description'] ?>">
                    <span class="text-danger"><?= $description_error ?></span>
                </div>
                <div class="w-25 p-2">
                    <div>availability status (automatic):</div>
                    <div class="border rounded w-100 bg-body-tertiary text-secondary myNotChangeable"><?= $row4 == NULL ? "available" : "not available"; ?></div>
                </div>
                <div class="w-25 p-2">
                    <label for="image">image:</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
            </div>
            <hr>
            <?php
            if($source == "animalList"){
                echo "<a href='dashboard_animal_list.php' class='btn btn-outline-dark'>Back</a>";
            } else {
                echo "<a href='home.php' class='btn btn-outline-dark'>Back</a>";
            }
            ?>
            <input type="submit" name="update_animal" class="btn btn-outline-warning" value="Update animal">
        </form>

    </div>

</div>

<?php require_once "components/_footer.php"?>
</body>
</html>
