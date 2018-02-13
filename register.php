<?php
$view = new stdClass();
$view->pageTitle = 'Register';
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
require_once('Models/User.php');
require_once('Models/DBConnection.php');
if(isset($_POST['submit'])){
    $server = new DBConnection();
    $conn = $server->connect();
    $user = new User($_POST['username']);
    $result = $user->createUser($conn, $_POST['password'], $_POST['address1'], $_POST['address2'], $_POST['mobile']);
    if($result == "Success"){
        session_unset();
        session_destroy();
        $view->status = "Registered Successfully";
        session_start();
        $_SESSION["user"] = $user->username;
        require_once('index.php');
        die();
    }else{
        $view->status = $result;
        session_unset();
        session_destroy();
        $view->error = 1;
    }
}
require_once('Views/register.phtml');