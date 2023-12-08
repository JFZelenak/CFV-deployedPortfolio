<?php
require_once "components/db_connect.php";

$sql = "SELECT * FROM `media`";
$result = mysqli_query($connect,$sql);

$cards = "";

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $cards .="
<div class='myCard'>
    <div class='d-flex flex-column justify-content-between h-100'>
        <div>
            <div class='imgContainer'>
                <img src='assets/{$row["image"]}' alt='image of the {$row["type"]} \"{$row["title"]}\"'>
            </div>
            <table class='table myTable'>
                <tr>
                    <th>title:</th>
                    <td>{$row["title"]}</td>
                </tr>
                <tr>
                    <th>publisher:</th>
                    <td>
                        <a href='publisher.php?publisher_name={$row["publisher_name"]}'>{$row["publisher_name"]}</a>
                    </td>
                </tr>
                <tr>
                    <th>status:</th>
                    <td>{$row["status"]}</td>
                </tr>
                <tr>
                    <th colspan='2'>description: </th>
                </tr>
                <tr>
                    <td colspan='2'>{$row["short_description"]}</td>
                </tr>
            </table>
        </div>
        <div>
            <div>
                <div class='d-flex justify-content-between myBtnContainer'>
                    <a href='details.php?id={$row["id"]}' class='btn btn-outline-dark'>Show details</a>
                    <a href='update.php?id={$row["id"]}' class='btn btn-outline-dark'>Edit</a>
                    <a href='components/delete.php?id={$row["id"]}' class='btn btn-outline-danger'>Delete</a>
                </div>
            </div> 
        </div>
    </div>
</div>        
        ";
    }
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
    <title>home</title>
    <?php require_once "components/_bootstrap-head.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once "components/_navbar.php"; ?>

    <!-- ------------------------ -->
    <!-- --------- main --------- -->
    <!-- ------------------------ -->
    <div class="d-flex flex-wrap justify-content-center">
        <?= $cards ?>
    </div>

    <?php require_once "components/_footer.php"; ?>
</div>

<?php require_once "components/_bootstrap-body.php"; ?>
</body>
</html>