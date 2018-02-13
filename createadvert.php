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
    $adSuccess = $ad->createAd($conn,$view->user,$_POST['title'],$_POST['desc'],$_POST['price'],$_FILES["fileToUpload"]);
    if($adSuccess) {
        $_GET["id"] = $ad->id;
        require_once("advert.php");
        die();
    }else{
        $view->status = $adSuccess;
    }
}
//show edit user page
require_once('Views/createadvert.phtml');