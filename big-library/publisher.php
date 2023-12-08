<?php
require_once "components/db_connect.php";

$publisher_name = $_GET['publisher_name'];
$sql = "SELECT * FROM `media` WHERE publisher_name = '$publisher_name'";
$result = mysqli_query($connect,$sql);

$cards = "";

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $cards .="
<div class='myCard'>
    <div class='d-flex flex-column justify-content-between h-100'>
        <div class='col col-12'>
            <div class='imgContainer'>
                <img src='assets/{$row["image"]}' alt='image of the {$row["type"]} \"{$row["title"]}\"'>
            </div>
            <div class='row'>
                <div class='col col-3'>
                    <ul>
                        <li>
                            <span>title: </span>
                        </li>
                        <li>
                            <span>publisher: </span>
                        </li>
                        <li>
                            <span>status: </span>
                        </li>
                    </ul>
                </div>
                <div class='col col-9'>
                    <ul>
                        <li>
                            {$row["title"]}
                        </li>
                        <li>
                            <a href='publisher.php'>{$row["publisher_name"]}</a>
                        </li>
                        <li>
                            {$row["status"]}
                        </li>
                    </ul>
                </div> 
            </div>
        </div>
        <div class='row'>
            <div class='col col-12'>
                <ul>
                   <li>
                        <span>description: </span>
                   </li>
                    <li>
                        {$row["short_description"]}
                    </li>
                </ul>
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
    <title>publisher</title>
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