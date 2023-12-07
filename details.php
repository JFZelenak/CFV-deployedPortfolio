<?php
require_once "components/db_connect.php";

$id = $_GET['id'];
$sql = "SELECT * FROM media WHERE id = $id";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

/*foreach ($row as $key => $value){
    echo "
        $key: $value <br>
        ";
}*/

mysqli_close($connect);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>details</title>
    <?php require_once "components/_bootstrap-head.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once "components/_navbar.php"; ?>

    <!-- ------------------------ -->
    <!-- --------- hero --------- -->
    <!-- ------------------------ -->
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src='assets/<?= $row["image"] ?>' class="d-block mx-lg-auto img-fluid" alt="image of the <?= $row["type"] ?> \'<?= $row["title"] ?>\'" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold mb-3"><?= $row["title"] ?></h2>
            <table class="table">
                <tr>
                    <th>published:</th>
                    <td><?= $row["publish_date"] ?></td>
                </tr>
                <tr>
                    <th>type:</th>
                    <td><?= $row["type"] ?></td>
                </tr>
                <tr>
                    <?php
                    if($row["type"] == 'book'){
                        echo "
                    <th>ISBN:</th>
                    ";
                    } else {
                        echo "
                    <th>EAN:</th>
                    ";
                    }
                    ?>
                    <td><?= $row["ISBN_EAN"] ?></td>
                </tr>
                <tr>
                    <th>description:</th>
                    <td><?= $row["short_description"] ?></td>
                </tr>
                <tr>
                    <th>author:</th>
                    <td><?= $row["author_first_name"] . " " . $row["author_last_name"] ?></td>
                </tr>
                <tr>
                    <th>publisher:</th>
                    <td><?= $row["publisher_name"] . "<br>" . $row["publisher_address"] ?></td>
                </tr>
                <tr>
                    <th>status:</th>
                    <td><?= $row["status"] ?></td>
                </tr>
            </table>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="index.php"><button type="button" class="btn btn-outline-dark px-4 me-md-2">Home</button></a>
            </div>
        </div>
    </div>

    <?php require_once "components/_footer.php"; ?>
</div>

<?php require_once "components/_bootstrap-body.php"; ?>
</body>
</html>