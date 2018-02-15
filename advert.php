<?php

$view = new stdClass();
require_once('Models/Advert.php');
$ad;
//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
//Redirect page if id hasnt been entered for ad
if(isset($_GET["id"]))
    $ad = new Advert($_GET["id"]);
else {
    require_once("index.php");
    die();
}
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
//Attempt to get details of ad
$details = $ad->getDetails($conn);
//Redirect if retrieval fails
if(!$details || is_string($details)) {
    require_once("index.php");
    die();
}else{
    //Assign details to view object
    $view->pageTitle = 'Advert';
    $view->adtitle = $details['title'];
    $view->desc = $details['description'];
    $view->price = $details['price'];
    $view->aduser = $details['username'];
    $view->digital = $details['digital'];
    $view->id = $ad->id;
    $view->img = array();
    //Get the urls of all uploaded images and add them to view array
    $imgPath = "images/adverts/" . $ad->id . "_*.*";
    foreach (glob($imgPath) as $filename) {
        array_push($view->img, $filename);
    }
}

//Checks if user is logged in
if(isset($_SESSION["user"])) {
    $view->user = $_SESSION["user"];
    //Check if ad is watched by user
    $view->watched = $ad->isWatched($conn,$view->user);
    //Check if user is trying to watch or unwatch an ad (clicking watch button)
    if (isset($_GET['w'])) {
        //Add ad to users watchlist if it isnt already
        if(!$view->watched && $_GET['w'] === '1'){
            $result = $ad->watchAd($conn,$view->user);
            if($result === "Success")
                $view->watched = true;

        //Remove from users watchlist if its there
        }elseif($view->watched && $_GET['w'] === '0'){
            $result = $ad->unwatchAd($conn,$view->user);
            if($result === "Success")
                $view->watched = false;

        }
    }
}

//Load page view
require_once('Views/advert.phtml');