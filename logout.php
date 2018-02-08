<?php
if(session_status() == 1)
    session_start();

session_unset();
session_destroy();
require_once('shop-login.php');
die();