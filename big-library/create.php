<?php
require_once "components/db_connect.php";
require_once "components/fileUpload.php";

function includesApostrophe($value) {
    return strpos($value, '\'') !== false;
}

if(isset($_POST["create"])){
    $values = ["title", "ISBN_EAN", "short_description", "author_first_name", "author_last_name", "publisher_name", "publish_date"];

    foreach ($values as $value) {
        $inputValue = $_POST[$value];

        if ($inputValue == "") {
            ${$value} = "missing $value";
        } elseif (includesApostrophe($inputValue)) {
            ${$value} = "invalid $value because of apostrophe";
        } else {
            ${$value} = $inputValue;
        }
    }

    $image = fileUpload($_FILES["image"]);
    $type = includesApostrophe($_POST["type"]) ? "invalid type" : $_POST["type"];
    $publisher_address = includesApostrophe($_POST["publisher_address"]) ? "invalid publisher_address" : $_POST["publisher_address"];
    $status = includesApostrophe($_POST["status"]) ? "invalid status" : $_POST["status"];

    $sql = "INSERT INTO media (title,ISBN_EAN,image,short_description,type,author_first_name,author_last_name,publisher_name,publisher_address,publish_date,status) VALUES ('$title','$ISBN_EAN','{$image[0]}','{$short_description}','$type','$author_first_name','$author_last_name','$publisher_name','$publisher_address','$publish_date','$status')";

    if(mysqli_query($connect,$sql)){
        echo "
        <div class='alert alert-success' role='alert'>
            new media object has been added to the databank, {$image[1]}
        </div>";
        header("refresh: 3; url= index.php");
    } else {
        echo "
        <div class='alert alert-danger' role='alert'>
            error found, new media object was not created, {$image[1]}
        </div>";
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
    <title>create</title>
    <?php require_once "components/_bootstrap-head.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once "components/_navbar.php"; ?>

    <!-- ------------------------ -->
    <!-- --------- main --------- -->
    <!-- ------------------------ -->
    <h3 class="mt-3">create new media object:</h3>
    <h6>mandatory fields are marked with *<br>
        apostrophe will make input invalid</h6>
    <hr>
    <form class="form" method="post" enctype="multipart/form-data">
        <div class="myMediaQueryCont">
            <label class="form-label myMediaQuery1 marginRight" for="title">
                title: <sup>*</sup>
                <input type="text" class="form-control" name="title" id="title">
            </label>
            <label class="form-label myMediaQuery1" for="ISBN_EAN">
                ISBN/EAN: <sup>*</sup>
                <input type="text" class="form-control" name="ISBN_EAN" id="ISBN_EAN">
            </label>
        </div>

        <label class="form-label w-100" for="image">
            image file:
            <input type="file" class="form-control" name="image" id="image">
        </label>

        <label class="form-label w-100" for="short_description">
            short description: <sup>*</sup>
            <textarea class="form-control" name="short_description" id="short_description"></textarea>
        </label>

        <div class="myMediaQueryCont">
            <label class="form-label myMediaQuery1 marginRight" for="author_first_name">
                author firstname: <sup>*</sup>
                <input type="text" class="form-control" name="author_first_name" id="author_first_name">
            </label>
            <label class="form-label myMediaQuery1" for="author_last_name">
                author lastname: <sup>*</sup>
                <input type="text" class="form-control" name="author_last_name" id="author_last_name">
            </label>
        </div>

        <label class="form-label w-100" for="publisher_name">
            publisher name: <sup>*</sup>
            <input type="text" class="form-control" name="publisher_name" id="publisher_name">
        </label>

        <label class="form-label w-100" for="publisher_address">
            publisher address:
            <input type="text" class="form-control" name="publisher_address" id="publisher_address">
        </label>

        <div class="myMediaQueryCont">
            <label class="form-label myMediaQuery1 marginRight" for="publish_date">
                choose publish date: <sup>*</sup>
                <input type="date" class="form-control" name="publish_date" id="publish_date">
            </label>
            <label class="form-label myMediaQuery2 marginRight" for="status">
                choose availability status: <sup>*</sup>
                <select class="form-control" name="status" id="status">
                    <option value="n/a" id="na">n/a</option>
                    <option value="available" id="available">available</option>
                    <option value="reserved" id="reserved">reserved</option>
                </select>
            </label>
            <label class="form-label myMediaQuery2" for="type">
                choose media type: <sup>*</sup>
                <select class="form-control" name="type" id="type">
                    <option value="n/a" id="na">n/a</option>
                    <option value="book" id="book">book</option>
                    <option value="cd" id="cd">CD</option>
                    <option value="dvd" id="dvd">DVD</option>
                </select>
            </label>
        </div>

        <div>
            <button name="create" type="submit" class="btn btn-outline-success">Create</button>
        </div>
    </form>

    <?php require_once "components/_footer.php"; ?>
</div>

<?php require_once "components/_bootstrap-body.php"; ?>
</body>
</html>