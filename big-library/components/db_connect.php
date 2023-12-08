<?php
$host = "5.189.178.173";
$user = "zelenakcodefacto_JFZelenak";
$pw = "Wczmbk5!Skkt4symm";
$dbname = "zelenakcodefacto_be20_cr4_johanneszelenak_biglibrary";

$connect = new mysqli($host, $user, $pw, $dbname);
if(!$connect){
    die("connection failed: ".mysqli_connect_error());
}
