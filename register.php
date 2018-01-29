<?php

$view = new stdClass();
$view->pageTitle = 'Register';
require_once('Models/User.php');
require_once('Models/DBConnection.php');
if(isset($_POST['submit'])){
        $server = new DBConnection();
        $conn = $server->connect();
        $user = new User($_POST['username'], $_POST['password']);
        if($user->createUser($conn)){
            session_destroy();
            $view->status = "Registered Successfully";
            session_start();
            $_SESSION["user"] = $user->username;
            //make session or somet
        }else{
            $view->status = "User with that email already exists";
        }
        $conn = null;

}
require_once('Views/register.phtml');