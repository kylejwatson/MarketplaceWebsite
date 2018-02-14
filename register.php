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
    if($_POST['captcha'] === $_SESSION["captcha"]) {
        session_unset();
        session_destroy();
        $server = new DBConnection();
        $conn = $server->connect();
        $user = new User($_POST['username']);
        $result = $user->createUser($conn, $_POST['password'], $_POST['address1'], $_POST['address2'], $_POST['mobile']);
        if ($result == "Success") {
            $view->status = "Registered Successfully";
            session_start();
            $_SESSION["user"] = $user->username;
            require_once('index.php');
            die();
        } else {
            $view->status = $result;
            $view->error = 1;
        }
    }else{
        $view->status = "Your input did not match the image try again";
        $view->error = 1;
    }
}
$a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
$_SESSION['captcha'] = $a_z[rand(0,51)] . $a_z[rand(0,51)] . $a_z[rand(0,51)] . $a_z[rand(0,51)];



//https://maymay.net/blog/2004/12/19/generating-random-letters-in-php/
function randLetter()
{
    $int = rand(0,51);
    $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $rand_letter = $a_z[$int];
    return $rand_letter;
}
require_once('Views/register.phtml');