<?php

$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
else
    //do somet to redirect page
$view->pageTitle = $view->user;

require_once('Models/User.php');
require_once('Models/DBConnection.php');
//show edit user page
require_once('Views/user.phtml');