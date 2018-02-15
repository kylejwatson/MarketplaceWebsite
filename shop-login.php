<?php

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
    if($user->login($conn, $_POST['password'])){
        $view->status = "Logged In Successfully";

        session_unset();
        session_destroy();

        session_start();
        $_SESSION["user"] = $user->username;
        $view->user = $_SESSION["user"];
        require_once('index.php');
        die();
        //make session or somet
    }else{
        $view->status = "Username or password entered incorrectly";
    }
    $conn = null;
}
require_once('Views/shop-login.phtml');