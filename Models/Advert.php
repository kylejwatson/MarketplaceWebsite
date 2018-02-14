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

    public function expireAds($conn){
        $stmt = $conn->prepare("DELETE FROM adverts WHERE (SELECT DATEDIFF(expire,CURDATE())) > 60");
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }

    public function searchAds($conn, $args,$dig){
        $in  = str_repeat('?,', count($dig) - 1) . '?';
        $stmt = $conn->prepare("SELECT id, title, price FROM adverts WHERE title LIKE ? AND description LIKE ? AND price <= ? AND price >= ? AND digital IN ($in)");
        $args[0] = "%".$args[0]."%";
        $args[1] = "%".$args[1]."%";
        $args[2] = ($args[2] === '' ? 99999 : $args[2]);
        $args[3] = ($args[3] === '' ? 0 : $args[3]);
        $result = $stmt->execute(array_merge($args,$dig));
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }

    public function createAd($conn, $user, $title,$description,$price,$digital,$list){
        $stmt = $conn->prepare("INSERT INTO adverts (title,description,price,username,digital,expire) VALUES (:title, :description, :price, :username, :digital, (SELECT ADDDATE(CURDATE(),60)))");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('price', $price);
        $stmt->bindValue('digital', ($digital ? 1 : 0));
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        $stmt = $conn->prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $this->id = $stmt->fetchColumn();
        return $this->uploadImages($list);
    }

    public function getDetails($conn){
        $stmt = $conn->prepare("SELECT title, description, price, username, digital FROM adverts WHERE id = :id");
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetch();
    }

    private function uploadImages($list){
        $target_dir = "images/adverts/";
        $target_file_id = $target_dir . $this->id . "_";
        $total = count($list["name"]);
        for ($i = 0; $i < $total; $i++) {
            if($list["error"][$i] !==0)
                return "No file selected";
            $imageFileType = strtolower(pathinfo($list["name"][$i], PATHINFO_EXTENSION));
            $target_file = $target_file_id  . $i . "." . $imageFileType;
            $check = getimagesize($list["tmp_name"][$i]);
            if ($check === false)
                return "No image file selected.";
            if (file_exists($target_file))
                return "Sorry, file already exists.";
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
                return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            if (!move_uploaded_file($list["tmp_name"][$i], $target_file))
                return "Sorry, there was an error uploading your file.";
        }
        return "Success";
    }

    public function getAds($conn){
        $stmt = $conn->prepare("SELECT id, title, price FROM adverts");
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }

    public function getSavedAds($conn, $user){
        $stmt = $conn->prepare("SELECT adverts.id, adverts.title, adverts.price FROM saved INNER JOIN adverts ON saved.id = adverts.id WHERE saved.username = :username");
        $stmt->bindParam('username', $user);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }

    public function isWatched($conn, $user){
        $stmt = $conn->prepare("SELECT id FROM saved WHERE id = :id AND username = :username");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return count($stmt->fetchAll()) > 0;
    }

    public function watchAd($conn, $user){
        $stmt = $conn->prepare("INSERT INTO saved (id,username) VALUES (:id, :username)");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }

    public function unwatchAd($conn, $user){
        $stmt = $conn->prepare("DELETE FROM saved WHERE id = :id AND username = :username");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }
}