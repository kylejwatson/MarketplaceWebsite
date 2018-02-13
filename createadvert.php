<?php

$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else{
    require_once('shop-login.php');
    die();
}
$view->pageTitle = 'Create Advert';
if(isset($_POST['submit'])) {
    require_once('Models/Advert.php');
    require_once('Models/DBConnection.php');
    $server = new DBConnection();
    $conn = $server->connect();
    $ad = new Advert('');
    $adSuccess = $ad->createAd($conn,$view->user,$_POST['title'],$_POST['desc'],$_POST['price']);
    if($adSuccess) {
        $target_dir = "images/adverts/";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $ad->id . "." . $imageFileType;
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $view->status = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $view->status = "File is not an image.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {
            $view->status = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $view->status = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $view->status = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            $view->status = "Sorry, there was an error uploading your file.";
        }
    }else{
        $view->status = $adSuccess;
    }
}
//show edit user page
require_once('Views/createadvert.phtml');