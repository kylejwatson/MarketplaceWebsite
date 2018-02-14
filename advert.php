<?php

$view = new stdClass();
require_once('Models/Advert.php');
$ad;
if(session_status() == 1)
    session_start();
if(isset($_GET["id"]))
    $ad = new Advert($_GET["id"]);
else {
    require_once("index.php");
    die();
}
$view->pageTitle = 'Advert';
require_once('Models/DBConnection.php');
$server = new DBConnection();
$conn = $server->connect();
$details = $ad->getDetails($conn);
if(is_string($details))
    $view->status = $details;
else{
    $view->adtitle = $details[0];
    $view->desc = $details[1];
    $view->price = $details[2];
    $view->aduser = $details[3];
    $view->id = $ad->id;
    $view->img = array();
    $imgPath = "images/adverts/" . $ad->id . "_*.*";
    foreach (glob($imgPath) as $filename) {
        //echo "$filename size " . filesize($filename) . "\n";
        array_push($view->img, $filename);
    }
    //$view->img = $details[3];
}
if(isset($_SESSION["user"])) {
    $view->user = $_SESSION["user"];
    $view->watched = $ad->isWatched($conn,$view->user);
    if (isset($_GET['w'])) {
        if(!$view->watched && $_GET['w'] === '1'){
            $result = $ad->watchAd($conn,$view->user);
            if($result === "Success"){
                $view->watched = true;
            }else{
                $view->status = $result;
            }

        }elseif($view->watched && $_GET['w'] === '0'){
            $result = $ad->unwatchAd($conn,$view->user);
            if($result === "Success"){
                $view->watched = false;
            }else{
                $view->status = $result;
            }
        }
    }
}
//show edit user page
require_once('Views/advert.phtml');