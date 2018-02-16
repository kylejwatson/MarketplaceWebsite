<?php

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(!isset($_SESSION["user"])) {
    //Redirect if not logged in
    require_once('shop-login.php');
    die();
}
if($_SESSION['user'] !== "admin@admin"){
    //Redirect if not logged in
    require_once('shop-login.php');
    die();
}

require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');
$ad->expireAds($conn);

require_once('index.php');
die();