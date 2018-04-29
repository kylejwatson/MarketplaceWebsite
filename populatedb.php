<?php

require_once('Models/Advert.php');
require_once('Models/User.php');
require_once('Models/DBConnection.php');
$conn = DBConnection::Instance();
//$ad = new Advert('');
//for($i = 1; true ; $i++){
//    //echo "$i <br>";
//    $userNo = ($i %5)+32;
//    //echo "$userNo <br>";
//    $err = $ad->createAd($conn,"user$userNo@example.com","$i-user$userNo's diff type example ad", "exampsadasdle \n deasdasdsc \n $i", $userNo*100+$i/400,($i%2 ? 1 : 0),array());
//    echo "$err <br>";
//    //echo "$ad->id <br>";
//    $userNo+= 3;
//    //echo "$userNo <br>";
//    $ad->watchAd($conn,"user$userNo@example.com");
//}
for($i = 1; true ; $i++){
    //echo "$i <br>";
    $userNo = ($i %5)+32;
    //echo "$userNo <br>";
    $user = new User("user$i@example.com");
    $err = $user->createUser($conn,"$i","$i Example Street, Exampleton","","000000$userNo");
    echo "$err <br>";
    //echo "$ad->id <br>";
}

//$stmt = $conn->prepare("ALTER TABLE adverts ADD FULLTEXT (title,description)");
//
//$result = $stmt->execute();
//
//if(!$result)
//    return "Statement Failed: ". $stmt->errorInfo();
//echo $stmt->fetchAll();