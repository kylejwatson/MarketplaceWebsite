<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 07/11/17
 * Time: 14:53
 */

class Advert
{
    /**
     * @var string
     */
    var $id = '';

    /**
     * User constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Called in order to delete all ads past their expiry date
     * @param PDO $conn
     * @return string
     */
    public function expireAds($conn){
        $stmt = $conn->prepare("DELETE FROM adverts WHERE (SELECT DATEDIFF(expire,CURDATE())) > 60");
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }

    /**
     * Search through ads where the all filters match: keyword searches if the string matches in the title or description
     * @param PDO $conn
     * @param array $args
     * @param array $dig
     * @return string|array
     */
    public function searchAds($conn, $args, $dig){
        $in  = str_repeat('?,', count($dig) - 1) . '?';
        $stmt = $conn->prepare("SELECT id, title, price FROM adverts WHERE (title LIKE ? OR description LIKE ?) AND price <= ? AND price >= ? AND digital IN ($in)");
        $args[0] = "%".$args[0]."%";
        $args[1] = "%".$args[1]."%";
        $args[2] = ($args[2] === '' ? 99999 : $args[2]);
        $args[3] = ($args[3] === '' ? 0 : $args[3]);
        $result = $stmt->execute(array_merge($args,$dig));
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }

    /**
     * Adds a new add to database and sets expiry date to 60 days from today
     * @param PDO $conn
     * @param string $user
     * @param string $title
     * @param string $description
     * @param string $price
     * @param bool $digital
     * @param array $list
     * @return string
     */
    public function createAd($conn, $user, $title, $description, $price, $digital, $list){
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
    /**
     * Delete ad from the database
     * @param PDO $conn
     * @param string $username
     * @return string
     */
    public function deleteAd($conn, $username){
        if($username === "admin@admin") {
            $stmt = $conn->prepare("DELETE FROM adverts WHERE id=:id");
            $stmt->bindParam('id', $this->id);
            $result = $stmt->execute();
            if (!$result) {
                return "Statement Failed: " . $stmt->errorInfo();
            }
            return "Success";
        }else{
            $stmt = $conn->prepare("DELETE FROM adverts WHERE id=:id AND username=:username");
            $stmt->bindParam('id', $this->id);
            $stmt->bindParam('username', $username);
            $result = $stmt->execute();
            if (!$result) {
                return "Statement Failed: " . $stmt->errorInfo();
            }
            return "Success";
        }
        return "Unauthorised";
    }
    /**
     * Edits ad details in the database and sets expiry date to 60 days from today
     * @param PDO $conn
     * @param string $user
     * @param string $title
     * @param string $description
     * @param string $price
     * @param bool $digital
     * @param array $list
     * @return string
     */
    public function editAd($conn, $title, $description, $price, $digital){
        $stmt = $conn->prepare("UPDATE adverts SET title=:title,description=:description,price=:price,digital=:digital,expire = (SELECT ADDDATE(CURDATE(),60)) WHERE id=:id");
        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('price', $price);
        $stmt->bindValue('digital', ($digital ? 1 : 0));
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }

    /**
     * Returns an array of details for the selected ad
     * @param PDO $conn
     * @return array|string
     */
    public function getDetails($conn){
        $stmt = $conn->prepare("SELECT title, description, price, username, digital FROM adverts WHERE id = :id");
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetch();
    }

    /**
     * Upload each image to the file server with names corresponding to the advert ID
     * @param array $list
     * @return string
     */
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

    /**
     * Gets every ad in the database
     * @param PDO $conn
     * @return string|array
     */
    public function getAds($conn){
        $stmt = $conn->prepare("SELECT id, title, price FROM adverts");
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }

    /**
     * Returns all ads on the users watch list including details needed to list them
     * @param PDO $conn
     * @param string $user
     * @return string|array
     */
    public function getSavedAds($conn, $user){
        $stmt = $conn->prepare("SELECT adverts.id, adverts.title, adverts.price FROM saved INNER JOIN adverts ON saved.id = adverts.id WHERE saved.username = :username");
        $stmt->bindParam('username', $user);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }

    /**
     * Checks if selected ad is on users watch list
     * @param PDO $conn
     * @param string $user
     * @return bool|string
     */
    public function isWatched($conn, $user){
        $stmt = $conn->prepare("SELECT id FROM saved WHERE id = :id AND username = :username");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return count($stmt->fetchAll()) > 0;
    }

    /**
     * Adds ad to users watch list
     * @param PDO $conn
     * @param string $user
     * @return string
     */
    public function watchAd($conn, $user){
        $stmt = $conn->prepare("INSERT INTO saved (id,username) VALUES (:id, :username)");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }

    /**
     * Removes ad from users watch list
     * @param PDO $conn
     * @param string $user
     * @return string
     */
    public function unwatchAd($conn, $user){
        $stmt = $conn->prepare("DELETE FROM saved WHERE id = :id AND username = :username");
        $stmt->bindParam('username', $user);
        $stmt->bindParam('id', $this->id);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return "Success";
    }

    /**
     * Toggles if ad is watched
     * @param PDO $conn
     * @param string $user
     * @param string $w
     * @return bool|string
     */
    public function setWatched($conn, $user, $w){
        $watched = $this->isWatched($conn, $user);
        if(!$watched && $w === '1'){
            $result = $this->watchAd($conn,$user);
            if($result === "Success")
                return true;
        }elseif($watched && $w === '0'){
            $result = $this->unwatchAd($conn,$user);
            if($result === "Success")
                return false;
        }
        return $watched;
    }
}