<?php
$view = new stdClass();
$view->pageTitle = 'Homepage';
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
require_once('Views/index.phtml');
