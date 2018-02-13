<?php

$view = new stdClass();
require_once('Models/Advert.php');
$ad;
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
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
    $view->img = array();
    $imgPath = "images/adverts/" . $ad->id . "_*.*";
    foreach (glob($imgPath) as $filename) {
        //echo "$filename size " . filesize($filename) . "\n";
        array_push($view->img, $filename);
    }
    //$view->img = $details[3];
}
//show edit user page
require_once('Views/advert.phtml');