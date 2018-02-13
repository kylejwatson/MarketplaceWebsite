<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 07/11/17
 * Time: 14:53
 */

class Advert
{
    var $id = '';

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function createAd($conn, $user, $title,$description,$price){
        $stmt = $conn->prepare("INSERT INTO adverts (title,description,price,username) VALUES (:title, :description, :price, :username)");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('price', $price);
        $result = $stmt->execute();
        if(!$result){
            return "Statement Failed: ". $stmt->errorInfo();
        }else {
            $stmt = $conn->prepare("SELECT LAST_INSERT_ID()");
            $stmt->execute();
            $this->id = $stmt->fetchColumn();
            return "Success";
        }
    }
}