<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Homepage';
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
require_once('Views/index.phtml');
