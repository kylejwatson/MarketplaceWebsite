<?php

$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];

$view->pageTitle = 'Search Adverts';
if(isset($_POST['submit'])) {
    require_once('Models/Advert.php');
    require_once('Models/DBConnection.php');
    $server = new DBConnection();
    $conn = $server->connect();
    $ad = new Advert('');
    $dig = array(0,1);
    $d = isset($_POST['digital']);
    $n = isset($_POST['notdigital']);
    if($d)
        $dig = array(1);
    if($n){
        if ($d)
            $dig = array(0,1);
        else
            $dig = array(0);
    }
    if(!isset($_POST['title']))
        $_POST['title'] = '';
    if(!isset($_POST['maxprice']))
        $_POST['maxprice'] = 9999.99;
    if(!isset($_POST['minprice']))
        $_POST['minprice'] = 0;
    $adSuccess = $ad->searchAds($conn,array($_POST['title'],$_POST['title'],$_POST['maxprice'],$_POST['minprice']),$dig);
    if (is_string($adSuccess)) {
        $view->status = $adSuccess;
    } else {
        $view->ads = $adSuccess;
        $view->img = array();
        foreach ($view->ads as $ad) {
            $imgPath = "images/adverts/$ad[0]_0.*";
            $result = glob($imgPath);
            if (count($result) > 0)
                array_push($view->img, glob($imgPath)[0]);
            else
                array_push($view->img, "images/adverts/default.png");
        }
        $view->total = count($view->ads);
    }
}

//show edit user page
require_once('Views/searchads.phtml');