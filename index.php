<?php

$view = new stdClass();

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];

$view->pageTitle = 'Adverts';

require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');

//Get a list of all ads with immediate details
$adSuccess = $ad->getAds($conn);
if(!is_string($adSuccess)){
    //If retrieval is successful set to view array
    $view->ads = $adSuccess;
    $view->img = array();
    //Get first image uploaded for each advert, and a default if no image was uploaded
    foreach($view->ads as $ad){
        $imgPath = "images/adverts/$ad[0]_0.*";
        $result = glob($imgPath);
        if(count($result)>0)
            array_push($view->img, glob($imgPath)[0]);
        else
            array_push($view->img,"images/adverts/default.png");
    }
    $view->total = count($view->ads);
}

//show page view
require_once('Views/adlist.phtml');