<?php
$host = "5.189.178.173";
$user = "zelenakcodefacto_JFZelenak";
$pw = "Burg&Auto!Panzer";
$dbname = "zelenakcodefacto_be20_cr4_johanneszelenak_biglibrary";

$connect = new mysqli($host, $user, $pw, $dbname);
if(!$connect){
    die("connection failed: ".mysqli_connect_error());
}
