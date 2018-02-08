<?php

$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else{
    require_once('shop-login.php');
    die();
}
$view->pageTitle = 'Create Advert';
if(isset($_POST['submit'])) {
    require_once('Models/User.php');
    require_once('Models/DBConnection.php');
    $server = new DBConnection();
    $conn = $server->connect();
    $user = new User($_POST['username']);
}
//show edit user page
require_once('Views/createadvert.phtml');