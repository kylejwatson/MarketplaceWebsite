<?php

$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else {
    require_once('shop-login.php');
    die();
}
$view->pageTitle = 'Watched List';

require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$server = new DBConnection();
$conn = $server->connect();
$ad = new Advert('');
$adSuccess = $ad->getSavedAds($conn,$view->user);
if(is_string($adSuccess)) {
    $view->status = $adSuccess;
}else{
    $view->ads = $adSuccess;
    $view->img = array();
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

//show edit user page
require_once('Views/watchadlist.phtml');