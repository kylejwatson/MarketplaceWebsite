<?php

//Start session if it hasn't already started (redirects)
if(session_status() == 1)
    session_start();

//Destroy all session data and redirect to login page
session_unset();
session_destroy();
require_once('shop-login.php');
die();