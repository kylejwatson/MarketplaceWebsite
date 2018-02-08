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
        $stmt = $conn->prepare("INSERT INTO adverts (title,description,username) VALUES (:title, :description, :username)");
        $stmt->bindParam('username', $this->username);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('description', $description);
        $result = $stmt->execute();
        if(!$result){
            return "Statement Failed: ". $stmt->errorInfo();
        }else {
            return "Success";
        }
    }
}