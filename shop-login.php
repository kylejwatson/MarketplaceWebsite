<?php
session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];

//


$view = new stdClass();
$view->pageTitle = 'Login';
require_once('Models/User.php');
require_once('Models/DBConnection.php');
if(isset($_POST['submit'])){
    $server = new DBConnection();
    $conn = $server->connect();
    $user = new User($_POST['username'], $_POST['password']);
    if($user->login($conn)){
        $view->status = "Logged In Successfully";

        session_unset();
        session_destroy();

        session_start();
        $_SESSION["user"] = $user->username;
        $view->user = $_SESSION["user"];
        require_once('index.php');
        //make session or somet
    }else{
        $view->status = "Username or password entered incorrectly";
        require_once('Views/shop-login.phtml');
    }
    $conn = null;
}