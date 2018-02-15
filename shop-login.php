<?php

//Start session if it hasn't already started (redirects)
$view = new stdClass();
$view->pageTitle = 'Login';
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];

if(isset($_POST['submit'])){
    require_once('Models/User.php');
    require_once('Models/DBConnection.php');
    $conn = DBConnection::Instance();
    $user = new User($_POST['username']);
    //attempt to login if details have been entered
    if($user->login($conn, $_POST['password'])){
        session_unset();
        session_destroy();
        //Logout if already logged in and login new user

        session_start();
        $_SESSION["user"] = $user->username;
        $view->user = $_SESSION["user"];
        //Redirect to homepage
        require_once('index.php');
        die();
    }else{
        $view->status = "Username or password entered incorrectly";
    }
}

//Show page view
require_once('Views/shop-login.phtml');