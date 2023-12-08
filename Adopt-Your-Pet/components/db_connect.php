<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "be20_cr5_animal_adoption_johanneszelenak";

$connect = new mysqli($host, $user, $pass, $dbname);

if(!$connect){
    die ("Connection failed: ". mysqli_connect_error());
}