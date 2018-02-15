<?php

$view = new stdClass();

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else{
    //Redirect if not logged in
    require_once('shop-login.php');
    die();
}
$view->pageTitle = 'Create Advert';

if(isset($_POST['submit'])) {
    require_once('Models/Advert.php');
    require_once('Models/DBConnection.php');
    $conn = DBConnection::Instance();
    $ad = new Advert('');
    //Add ad to database if details have been submitted
    $adSuccess = $ad->createAd($conn,$view->user,$_POST['title'],$_POST['desc'],$_POST['price'],isset($_POST['digital']),$_FILES["fileToUpload"]);
    if($adSuccess) {
        //Redirect to ad display page if ad successfully uploaded
        $_GET["id"] = $ad->id;
        require_once("advert.php");
        die();
    }
}
//show page view
require_once('Views/createadvert.phtml');