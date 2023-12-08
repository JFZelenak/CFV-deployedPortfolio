<?php
session_start();

require_once "./components/db_connect.php";

$id = $_GET["id"];
$source = $_GET["source"];

$sql3 = "SELECT * FROM pet_adopt WHERE fk_pet_id = $id";
$result3 = mysqli_query($connect, $sql3);
/*var_dump($result3);
echo "<br>";*/
$row3 = mysqli_fetch_assoc($result3);
/*var_dump($row3);*/

$availabilityCheck = ($row3 == NULL) ? "available" : "not_available";
$sql4 = "UPDATE animal SET status = '$availabilityCheck' WHERE id = '$id'";
$result4 = mysqli_query($connect, $sql4);

$sql2 = "SELECT * FROM animal WHERE id = $id" ;
$result2 = mysqli_query($connect, $sql2);
$row2 = mysqli_fetch_assoc($result2);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adopt-Your-Pet details</title>
    <?php require_once "./components/_head-links.php"?>
</head>
<body>
<?php require_once "./components/_navbar.php"?>
<?php require_once "./components/_hero.php"?>

<div class="container">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="assets/<?= $row2["image"] ?>" class="d-block mx-lg-auto img-fluid" width="700" height="500" loading="lazy" alt="Image of <?= $row2["pet_name"] ?> the <?= $row2["type"] ?>">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3"><?= $row2["pet_name"] ?></h1>
            <table class="table">
                <tr>
                    <th>Type:</th>
                    <td><?= $row2["type"] ?></td>
                </tr>
                <tr>
                    <th>Breed:</th>
                    <td><?= $row2["breed"] ?></td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td><?= $row2["description"] ?></td>
                </tr>
                <tr>
                    <th>Size:</th>
                    <td>
                        <?php
                        switch ($row2["size"]) {
                            case "xs":
                                echo "extra small";
                                break;
                            case "sm":
                                echo "small";
                                break;
                            case "md":
                                echo "medium";
                                break;
                            case "lg":
                                echo "large";
                                break;
                            case "xl":
                                echo "extra large";
                                break;
                            default:
                                echo "n/a";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Age:</th>
                    <td><?= $row2["age"] != 1 ? $row2["age"] . " years" : $row2["age"] . " year" ?></td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td><?= $row2["address"] ?></td>
                </tr>
                <tr>
                    <th>vaccination status:</th>
                    <td><?= $row2["vaccinated"] == "vaccinated" ? "vaccinated" : "not vaccinated" ?></td>
                </tr>
                <tr>
                    <th>adoption status:</th>
                    <td><?= $row3 == NULL ? "available" : "not available"; ?></td>
                </tr>
            </table>
            <?php
            if($source == "animalList") {
                echo "<a href='dashboard_animal_list.php' class='btn btn-outline-dark'>Back</a>";
            } else {
                echo "<a href='home.php' class='btn btn-outline-dark'>Back</a>";
            }
            if(isset($_SESSION["user"]) && $row2["status"] == "available"){
               echo "<a href='components/adopt.php?source=one_click&id={$row2["id"]}' class='btn btn-outline-success ms-2'>1click Take me home</a>";
            }
            ?>

        </div>
    </div>
</div>

<?php require_once "./components/_footer.php"?>
</body>
</html>