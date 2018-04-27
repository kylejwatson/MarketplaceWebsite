<?php

//Start session if it hasn't already started (redirects)
$view = new stdClass();
require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');
$view->limit = 12;
$view->offset = 1;
if(isset($_POST['offset']) ){
    $view->offset = (int) $_POST['offset'];
}
//Create an array for checkboxes if details have been submitted
$dig = array(0,1);
$d = isset($_POST['digital']);
$n = isset($_POST['notdigital']);
//Check for real and digital if both or none have been selected
if($d)
    $dig = array(1,1);
if($n){
    if ($d)
        $dig = array(0,1);
    else
        $dig = array(0,0);
}
//Set defaults if filters havent been entered
if(!isset($_POST['title']))
    $_POST['title'] = '';
if(!isset($_POST['maxprice']))
    $_POST['maxprice'] = 9999.99;
if(!isset($_POST['minprice']))
    $_POST['minprice'] = 0;
//Fetch every matching adverts imediate details
$adSuccess = $ad->searchAds($conn,$_POST['title'],(float) $_POST['maxprice'],(float) $_POST['minprice'],$dig, $view->limit, $view->offset);
if(count($adSuccess) !== 0 &! is_string($adSuccess)) {
    $view->ads = $adSuccess;
    $view->img = array();
    //Get first image for each ad and add to array
    foreach ($view->ads as $ad) {
        $imgPath = "images/adverts/$ad[0]_0.*";
        $result = glob($imgPath);
        if (count($result) > 0)
            array_push($view->img, glob($imgPath)[0]);
        else
            array_push($view->img, "images/adverts/default.png");
    }
    $view->total = count($view->ads);

    //showpage view
    require_once('Views/nextads.phtml');
}
