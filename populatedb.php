<?php

require_once('Models/Advert.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
$ad = new Advert('');
for($i = 1; $i <100000; $i++){
    //echo "$i <br>";
    $userNo = ($i %5)+32;
    //echo "$userNo <br>";
    $err = $ad->createAd($conn,"user$userNo@example.com","$i-user$userNo's diff type example ad", "exampsadasdle \n deasdasdsc \n $i", $userNo*100+$i/200,($i%2 ? 1 : 0),array());
    echo "$err <br>";
    //echo "$ad->id <br>";
    $userNo+= 3;
    //echo "$userNo <br>";
    $ad->watchAd($conn,"user$userNo@example.com");
}