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
    public function searchAds($conn, $title,$max,$min, $dig, $limit, $offset){
        $offset -= 1;
        $offset *= $limit;
        $title = '%'.$title.'%';
        /*$newAd = strip_tags($args[0]);
        if($newAd !== $args[0])
            return "No special characters allowed in title";
        $newAd = strip_tags($args[1]);
        if($newAd !== $args[1])
            return "No special characters allowed in description";
        $newAd = strip_tags($args[3]);
        if($newAd !== $args[3])
            return "No special characters allowed in max price";
        $newAd = strip_tags($args[3]);
        if($newAd !== $args[3])
            return "No special characters allowed in min price";
        $in  = str_repeat('?,', count($dig) - 1) . '?';*/
        $stmt = $conn->prepare("SELECT id, title, price FROM adverts WHERE (title LIKE :title OR description LIKE :title) AND price <= :maximum AND price >= :minimum AND digital IN (:digital1,:digital2) ORDER BY expire DESC LIMIT :limit OFFSET :offset");
        $stmt->bindParam('title', $title);
        //$stmt->bindParam('description', $description);
        $stmt->bindParam('maximum', $max);
        $stmt->bindParam('minimum', $min);
        $stmt->bindValue('digital1', $dig[0],  PDO::PARAM_INT);
        $stmt->bindValue('digital2', $dig[1],  PDO::PARAM_INT);
        $stmt->bindParam('limit', $limit,  PDO::PARAM_INT);
        $stmt->bindParam('offset', $offset,  PDO::PARAM_INT);
        $result = $stmt->execute();

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
        if(strlen($title)>45)
            return "Title must be less than 45 characters";
        if(strip_tags($title) !== $title)
            return "No special characters allowed in title";
        if(strlen($description)>254)
            return "Description must be less than 254 characters";
        if(strip_tags($description) !== $description)
            return "No special characters allowed in description";
        if(!is_numeric($price))
            return "Price must be a number";
        if(floatval($price)<0)
            return "Price cannot be less than £0";
        if(floatval($price)>9999.99)
            return "Price cannot be more than £9999.99";

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
        if(strlen($title)>45)
            return "Title must be less than 45 characters";
        if(strip_tags($title) !== $title)
            return "No special characters allowed in title";
        if(strlen($description)>254)
            return "Description must be less than 254 characters";
        if(strip_tags($description) !== $description)
            return "No special characters allowed in description";
        if(!is_numeric($price))
            return "Price must be a number";
        if(floatval($price)<0)
            return "Price cannot be less than £0";
        if(floatval($price)>9999.99)
            return "Price cannot be more than £9999.99";
        $stmt = $conn->prepare("UPDATE adverts SET title=:title,description=:description,price=:price,digital=:digital,expire = (SELECT ADDDATE(CURDATE(),60)) WHERE id=:id");
        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('title', $title);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('price', $price);
        $stmt->bindValue('digital', ($digital ? 1 : 0));
        $stmt->bindParam('limit', $limit,  PDO::PARAM_INT);
        $stmt->bindParam('offset', $offset,  PDO::PARAM_INT);
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
     * Gets number of ads in the database
     * @param PDO $conn
     * @return string|array
     */
    public function countAds($conn){
        $stmt = $conn->prepare("SELECT COUNT(*) FROM adverts");
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetch()[0];
    }

    /**
     * Gets every ad in the database
     * @param PDO $conn
     * @return string|array
     */
    public function getAds($conn, $limit, $offset){
        $query = "SELECT id, title, price FROM adverts ORDER BY expire DESC LIMIT :limit OFFSET :offset";
        $offset -= 1;
        $offset *= $limit;
        $stmt = $conn->prepare($query);
        $stmt->bindParam('limit', $limit,  PDO::PARAM_INT);
        $stmt->bindParam('offset', $offset,  PDO::PARAM_INT);
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