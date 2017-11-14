<?php

$view = new stdClass();
$view->pageTitle = 'Login';
require_once('Models/User.php');
if(isset($_POST['submit'])){
    $servername = "helios.csesalford.com";
    $username = "stc905";
    $password = "turtlebrainholocaust";
    $dbname = "stc905";
    try {
        // Create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Check connection

        $user = new User($_POST['username'], $_POST['password']);
        if($user->login($conn)){
            $view->status = "Logged In Successfully";
            session_start();
            $_SESSION["user"] = $user->username;
            //make session or somet
        }else{
            $view->status = "Username or password entered incorrectly";
        }
        $conn = null;
    }catch(PDOException $e){
        die("Connection Error: ".$e->getMessage());
    }
}
require_once('Views/shop-login.phtml');