<?php

$view = new stdClass();
//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else {
    //Redirect to login if not already
    require_once('shop-login.php');
    die();
}
//Redirect page if id hasnt been entered for user
if(isset($_GET["id"])) {
    require_once('Models/User.php');
    $user = new User($_GET["id"]);
}else {
    require_once("index.php");
    die();
}

require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();

if(isset($_POST['submit']) && ($_SESSION['user'] === "admin@admin" || $_SESSION['user'] === $user->username)){
    $conn = DBConnection::Instance();
    //Add new user to database
    $result = $user->editUser($conn, $_POST['password'], $_POST['address1'], $_POST['address2'], $_POST['mobile']);
    if ($result != "Success") {
        $view->status = $result;
    }
}
//Attempt to get details of user
$details = $user->getDetails($conn);
//Redirect if retrieval fails
if(!$details || is_string($details)) {
    require_once("index.php");
    die();
}else{
    //Assign details to view object
    $view->pageTitle = 'User';
    $view->username = $details['username'];
    $view->address1 = $details['address1'];
    $view->address2 = $details['address2'];
    $view->mobile = $details['mobile'];
}


//Load page view
require_once('Views/user.phtml');