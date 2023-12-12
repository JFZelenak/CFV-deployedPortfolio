<?php
$host = "5.189.178.173";
$user = "zelenakcodefacto_JFZelenak";
$pass = "Burg&Auto!Panzer";
$dbname = "zelenakcodefacto_be20_cr5_animal_adoption_johanneszelenak";

$connect = new mysqli($host, $user, $pass, $dbname);

if(!$connect){
    die ("Connection failed: ". mysqli_connect_error());
}