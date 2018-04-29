<?php
$view = new stdClass();
if(session_status() == 1)
    session_start();
if(isset($_SESSION["user"]))
    $view->user = $_SESSION["user"];
if($_SESSION['user'] !== "admin@admin"){
    //Redirect if not logged in
    require_once('shop-login.php');
    die();
}

require_once('Models/User.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$user = new User('');
$view->limit = 12;
$view->offset = 1;
if(isset($_POST['offset']) ){
    $view->offset = (int) $_POST['offset'];
}

//Get a list of all ads with immediate details
$userSuccess = $user->getUsers($conn, $view->limit, $view->offset);
if(!is_string($userSuccess)){
    //If retrieval is successful set to view array
    $view->users = $userSuccess;
}

//show page view
foreach ($view->users as $user) {
    echo "<li class='list-group-item row'> <a href='user.php?id=$user[0]' >$user[0]</a><a class='btn btn-default pull-right' href='userlist.php?id=$user[0]'> Delete </a></li>";
}

