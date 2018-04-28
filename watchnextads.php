<?php

$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else {
    //Redirect to login if not already
    require_once('shop-login.php');
    die();
}

require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');
$view->limit = 12;
$view->offset = 1;
if(isset($_POST['offset']) ){
    $view->offset = (int) $_POST['offset'];
}
//echo $view->offset;

//Retrieve list of saved ads
$adSuccess = $ad->getSavedAds($conn, $view->user, $view->limit, $view->offset);
if(count($adSuccess) !== 0) {
    $view->ads = $adSuccess;
    $view->img = array();
    //Get first image for each ad
    foreach($view->ads as $advert){
        $imgPath = "images/adverts/$advert[0]_0.*";
        $result = glob($imgPath);
        if(count($result)>0)
            array_push($view->img, glob($imgPath)[0]);
        else
            array_push($view->img,"images/adverts/default.png");
    }
    $view->total = count($view->ads);
    $view->watch = true;
//show page view
    require_once('Views/nextads.phtml');
}
