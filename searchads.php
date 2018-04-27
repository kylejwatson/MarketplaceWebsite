<?php

//Start session if it hasn't already started (redirects)
$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];

$view->pageTitle = 'Search Adverts';
if(isset($_POST['submit'])) {
    $view->title = $_POST['title'];
}

//showpage view
require_once('Views/searchads.phtml');