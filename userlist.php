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

//Get a list of all ads with immediate details
$userSuccess = $user->getUsers($conn);
if(!is_string($userSuccess)){
    //If retrieval is successful set to view array
    $view->users = $userSuccess;
}

//show page view
require_once('Views/userlist.phtml');