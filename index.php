<?php

$view = new stdClass();
require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"])) {
    $view->user = $_SESSION["user"];

    if(isset($_GET['id']) ){
        $advert = new Advert($_GET['id']);
        $advert->deleteAd($conn, $view->user);
    }
}

$view->pageTitle = 'Adverts';

//show page view
require_once('Views/adlist.phtml');