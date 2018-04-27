<?php
$view = new stdClass();
require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');
$view->limit = 5;
$view->offset = 1;
if(isset($_POST['offset']) ){
    $view->offset = (int) $_POST['offset'];
}
$view->count = $ad->countAds($conn);
//Get a list of all ads with immediate details
$adSuccess = $ad->getAds($conn, $view->limit, $view->offset);
if(!is_string($adSuccess)){
    //If retrieval is successful set to view array
    $view->ads = $adSuccess;
    $view->img = array();
    //Get first image uploaded for each advert, and a default if no image was uploaded
    foreach($view->ads as $ad){
        $imgPath = "images/adverts/$ad[0]_0.*";
        $result = glob($imgPath);
        if(count($result)>0)
            array_push($view->img, glob($imgPath)[0]);
        else
            array_push($view->img,"images/adverts/default.png");
    }
    $view->total = count($view->ads);
    $result = array($adSuccess,$view->img,$view->total);
    echo json_encode($result);
}

//show page view
//require_once('Views/nextads.phtml');