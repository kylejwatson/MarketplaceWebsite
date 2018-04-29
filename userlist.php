<?php

$view = new stdClass();

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
if($_SESSION['user'] !== "admin@admin"){
    //Redirect if not logged in
    require_once('shop-login.php');
    die();
}

$view->pageTitle = 'Users';

require_once('Models/User.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$user = new User('');
if(isset($_GET['id'])){
    $user->username = $_GET['id'];
    $user->deleteUser($conn);
}
//show page view
require_once('Views/userlist.phtml');