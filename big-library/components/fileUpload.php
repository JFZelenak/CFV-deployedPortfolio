<?php
function fileUpload($image){

    if($image["error"] == 4){
        $imageName = "default.jpg";
        $message = "No image has been chosen";
    } else{
        $checkIfImage = getimagesize($image["tmp_name"]);
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if($message == "Ok"){
        $ext = strtolower(pathinfo($image[ "name"],PATHINFO_EXTENSION));
        $imageName = uniqid( ""). "." . $ext;
        $destination = "assets/{$imageName}";
        move_uploaded_file($image["tmp_name"], $destination);
    }

    return [$imageName, $message];
}
