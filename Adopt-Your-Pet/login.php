<?php
session_start();

if(isset($_SESSION["adm"])){
    header("Location: dashboard.php");
} elseif(isset($_SESSION["user"])){
    header("Location: home.php");
}

require_once "components/db_connect.php";
require_once "components/clean.php";

$error = false;

$email = "" ;
$email_error = $password_error = "";

if(isset($_POST["login"])){
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);

    if (empty($email)) {
        $error = true ;
        $email_error = "Email can't be empty!";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true ;
        $email_error = "Please enter a valid email address." ;
    }

    if (empty($password)) {
        $error = true ;
        $password_error = "Password can't be empty!";
    }

    if(!$error){
        $password = hash( "sha256", $password);

        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'" ;
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        /*var_dump($sql);*/

        if (mysqli_num_rows($result) == 1){
            if ($row["status"] == "adm" ){
                $_SESSION["adm"] = $row["id"];
                header( "refresh: 3; url= dashboard.php" );
            } else  {
                $_SESSION["user"] = $row["id"];
                header( "refresh: 3; url= home.php" );
            }
            echo "
            <div class='alert alert-success'>
                <p class='w-100 text-center'>
                    You are logged in!
                </p>
            </div>
            ";
        } else  {
            echo "
            <div class='alert alert-danger'>
                <p class='w-100 text-center'>
                    Something went wrong! Please try again later.
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
    <title>Adopt-Your-Pet home</title>
    <?php require_once "components/_head-links.php"?>
</head>
<body>
<?php require_once "components/_navbar.php"?>
<?php require_once "components/_hero.php"?>
<div class="container">
    <h4 class="text-center mt-3">Login:</h4>
    <form method="POST" class="w-100 d-flex flex-column align-items-center">
        <label>
            Email:
            <input type="email" name="email" class="form-control">
        </label>
                <label>
            Password:
            <input type="password" name="password" class="form-control">
        </label>
        <input type="submit" name="login" class="btn btn-outline-success mt-2" value="Login">
    </form>
</div>
<?php require_once "components/_footer.php"?>
</body>
</html>
