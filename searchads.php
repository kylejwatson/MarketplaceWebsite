<?php

//Start session if it hasn't already started (redirects)
$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];

$view->pageTitle = 'Search Adverts';
if(isset($_POST['submit'])) {

    $d = isset($_POST['digital']);
    $n = isset($_POST['notdigital']);

    if(!isset($_POST['title']))
        $_POST['title'] = '';
    if(!isset($_POST['maxprice']))
        $_POST['maxprice'] = 9999.99;
    if(!isset($_POST['minprice']))
        $_POST['minprice'] = 0;

    $view->dig = $d;
    $view->not = $n;
    $view->title = $_POST['title'];
    $view->max = $_POST['maxprice'];
    $view->min = $_POST['minprice'];

}

//showpage view
require_once('Views/searchads.phtml');