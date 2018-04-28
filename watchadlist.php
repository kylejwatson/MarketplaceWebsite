<?php

//Start session if it hasn't already started (redirects)
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
$view->pageTitle = 'Watched List';

require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');
if (isset($_GET['w']) && isset($_GET['id'])) {
    $ad->id = $_GET['id'];
    $ad->setWatched($conn, $view->user, $_GET['w']);
}

//Retrieve list of saved ads
//$adSuccess = $ad->getSavedAds($conn,$view->user);
//if(count($adSuccess) !== 0) {
//    $view->ads = $adSuccess;
//    $view->img = array();
//    //Get first image for each ad
//    foreach($view->ads as $advert){
//        $imgPath = "images/adverts/$advert[0]_0.*";
//        $result = glob($imgPath);
//        if(count($result)>0)
//            array_push($view->img, glob($imgPath)[0]);
//        else
//            array_push($view->img,"images/adverts/default.png");
//    }
//    $view->total = count($view->ads);
//}

//show page view
require_once('Views/watchadlist.phtml');