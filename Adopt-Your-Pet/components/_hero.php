<?php

require_once "db_connect.php";

$row = array("");

if(isset($_SESSION["adm"]) || isset($_SESSION["user"])) {
    $id = $_SESSION["adm"] ?? $_SESSION["user"];
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
}

echo "
<div class='container border-bottom'>
    <div id='myHeroContainer'>
        <div class='myHeroImageContainer'>
            <img src='assets/hero_happy-animals.jpg' alt='picture of happy pets'>
        </div>

        <div class='d-flex flex-column align-items-center myHeroTextContainer p-2 mt-5 h-100'>
            <div class='h2 text-center'>Adopt-Your-Pet</div>
            <div class='h5 text-center'>Our lovely pets are looking for a lovely home! Have a look!</div>
        </div>   

        <div class='myHeroImageContainer'>
        ";
if(isset($_SESSION["adm"]) || isset($_SESSION["user"])){
    echo "
            <div class='p-4 h-100 mySessionContainer'>
                <img src='assets/{$row["image"]}' alt='user picture'>
                <p class='w-100 text-center'>{$row["email"]}</p>
            </div>
    ";
} else {
    echo "<img src='assets/hero_happy-family.jpg' alt='picture of happy pets'>";
}
echo "
        </div>
    </div>
</div>

";