<?php
$view = new stdClass();
$view->pageTitle = 'Register';

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
require_once('Models/User.php');
require_once('Models/DBConnection.php');
if(isset($_POST['submit'])){
    //Check if captcha input matches captcha image
    if($_POST['captcha'] === $_SESSION["captcha"]) {

        $conn = DBConnection::Instance();
        $user = new User($_POST['username']);
        //Add new user to database
        $result = $user->createUser($conn, $_POST['password'], $_POST['address1'], $_POST['address2'], $_POST['mobile']);
        if ($result == "Success") {
            $view->status = "Registered Successfully";
            //If successful logout if logged in and login new user
            session_unset();
            session_destroy();
            session_start();
            $_SESSION["user"] = $user->username;
            //redirect to home page
            require_once('index.php');
            die();
        } else {
            //If username already registered show login button
            $view->error = 1;
            $view->status = $result;
        }
    }else{
        //Display captcha error
        $view->status = "Your input did not match the image try again";
    }
}

//List all english letters/numbers to choose from for captcha
$letterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//Generate 4 random letters/numbers
$_SESSION['captcha'] = $letterList[rand(0,61)] . $letterList[rand(0,61)] . $letterList[rand(0,61)] . $letterList[rand(0,61)];

require_once('Views/register.phtml');