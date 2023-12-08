<?php
function fileUpload($image, $source){

    if($image["error"] == 4){

        if($source == "animal" || $source == "animalList"){
            $imageName = "default_animal.jpg";
        } elseif($source == "userList" || $source == "user") {
            $imageName = "default_user.jpg";
        }
        $message = "No image has been chosen. You can upload an image later." ;
    }else{
        $checkIfImage = getimagesize($image["tmp_name" ]);
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if($message == "Ok"){
        $ext = strtolower(pathinfo($image["name" ],PATHINFO_EXTENSION));
        $imageName = uniqid("" ). "." . $ext;
        $destination = "assets/{$imageName}";

        move_uploaded_file($image["tmp_name" ], $destination);
    }

    return  [$imageName, $message];
}