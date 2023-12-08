<?php
session_start();

if(!isset($_SESSION["adm"])){
    header("Location: home.php");
}

require_once "components/db_connect.php";
require_once "components/file_upload.php";
require_once "components/clean.php";

$error = false;
$first_name_error = $last_name_error = $email_error = $password_error = $phone_nr_error = $address_error = "";
$id = $_GET["id"];

$sql2 = "SELECT * FROM user WHERE id = '$id'";
$result2 = mysqli_query($connect, $sql2);
$row2 = mysqli_fetch_assoc($result2);

if(isset($_POST["update"])) {
    $first_name = cleanInputs($_POST["first_name"]);
    $last_name = cleanInputs($_POST["last_name"]);
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);
    $phone_nr = cleanInputs($_POST["phone_nr"]);
    $address = cleanInputs($_POST["address"]);
    $image = fileUpload($_FILES["image"],"userList");

    $sameValidation = array($first_name,$last_name,$address);
    foreach ($sameValidation as $key=>$item){
        if(empty($item)){
            $error = true;
            $sameMessage = "Please, enter your ";
            if($key==0) {
                $first_name_error = $sameMessage . "first name";
            } elseif($key==1){
                $last_name_error = $sameMessage . "last name";
            } elseif($key==2){
                $address_error = $sameMessage . "address";
            }
        } elseif(strlen($item) < 3){
            $error = true;
            $sameMessage = "Must have at least 3 characters.";
            if($key==0) {
                $first_name_error = $sameMessage;
            } elseif($key==1){
                $last_name_error = $sameMessage;
            } elseif($key==2){
                $address_error = $sameMessage;
            }
        } elseif(!preg_match( "/^[a-zA-Z0-9\s\/.,]+$/" , $item)){
            $error = true;
            $sameMessage = "Must contain only letters, numbers, slashes, dot, comma and spaces.";
            if($key==0) {
                $first_name_error = $sameMessage;
            } elseif($key==1){
                $last_name_error = $sameMessage;
            } elseif($key==2){
                $address_error = $sameMessage;
            }
        }
    }

    if (empty($email)) {
        $error = true ;
        $email_error = "Email can't be empty!" ;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true ;
        $email_error = "Please enter a valid email address." ;
    } else {
        $query = "SELECT email FROM user WHERE email='$email' AND id != '$id'" ;
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) != 0 ){
            $error = true ;
            $email_error = "Provided Email is already in use." ;
        }
    }

    if (empty($phone_nr)) {
        $error = true ;
        $phone_nr_error = "Phone number can't be empty!" ;
    } elseif (strlen($phone_nr) < 4 ) {
        $error = true ;
        $phone_nr_error = "Phone number must have at least 4 characters." ;
    } elseif (!preg_match( "/^[0-9\s\/]+$/" , $phone_nr)) {
        $error = true;
        $phone_nr_error = "Phone number can only contain numbers, slashes and spaces.";
    }

    if (empty($password)) {
        $error = true ;
        $password_error = "Password can't be empty!" ;
    } elseif (strlen($password) < 6 ) {
        $error = true ;
        $password_error = "Password must have at least 6 characters." ;
    }

    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "UPDATE user SET
                first_name = '$first_name',
                last_name = '$last_name',
                email = '$email',
                password = '$password',
                phone_nr = '$phone_nr',
                address = '$address',
                image = '$image[0]',
                status = 'user'
                WHERE id = '$id'";

        if(mysqli_query($connect, $sql)){
            echo "
                <div class='alert alert-success'>
                    <p class='w-100 text-center'>
                        User update complete!
                    </p>
                </div>
                ";
            header("refresh: 3; url=dashboard_user_list.php");
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
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adopt-Your-Pet register</title>
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
    <h4 class="text-center mt-3">Update <?= $row2['status'] ?> "<?= $row2['first_name'] ?> <?= $row2['last_name'] ?>":</h4>
    <form action="" method="POST" enctype="multipart/form-data" class="w-100">
        <div class="row row-cols-1 row-cols-md-2">
            <label>
                First name:
                <input type="text" name="first_name" class="form-control" value="<?= $row2['first_name'] ?>">
                <span class="text-danger"><?= $first_name_error ?></span>
            </label>
            <label>
                Last name:
                <input type="text" name="last_name" class="form-control" value="<?= $row2['last_name'] ?>">
                <span class="text-danger"><?= $last_name_error ?></span>
            </label>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <label>
                Email:
                <input type="text" name="email" class="form-control" value="<?= $row2['email'] ?>">
                <span class="text-danger"><?= $email_error ?></span>
            </label>
            <label>
                Phone number:
                <input type="text" name="phone_nr" class="form-control" value="<?= $row2['phone_nr'] ?>">
                <span class="text-danger"><?= $phone_nr_error ?></span>
            </label>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <label>
                Address:
                <input type="text" name="address" class="form-control" value="<?= $row2['address'] ?>">
                <span class="text-danger"><?= $address_error ?></span>
            </label>
            <label>
                Profile picture:
                <input type="file" name="image" class="form-control">
            </label>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <label>
                Password:
                <input type="password" name="password" class="form-control">
                <span class="text-danger"><?= $password_error ?></span>
            </label>
        </div>
        <a href="dashboard_user_list.php" class="btn btn-outline-dark mt-3">Back</a>
        <input type="submit" name="update" class="btn btn-outline-warning mt-3" value="Update">
    </form>
</div>

<?php require_once "components/_footer.php"?>
</body>
</html>