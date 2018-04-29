<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 07/11/17
 * Time: 14:53
 */

class User
{
    /**
     * @var string
     */
    var $username = '';

    /**
     * User constructor.
     * @param string $username
     */
    public function __construct($username)
    {
        $this->username = $username;
    }


    /**
     * Gets every user in the database
     * @param PDO $conn
     * @return string|array
     */
    public function getUsers($conn, $limit, $offset){
        $offset -= 1;
        $offset *= $limit;
        $stmt = $conn->prepare("SELECT username FROM users ORDER BY username DESC LIMIT :limit OFFSET :offset");

        $stmt->bindParam('limit', $limit,  PDO::PARAM_INT);
        $stmt->bindParam('offset', $offset,  PDO::PARAM_INT);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetchAll();
    }


    /**
     * Returns an array of details for the selected user
     * @param PDO $conn
     * @return array|string
     */
    public function getDetails($conn){
        if(strlen($this->username)>100)
            return "Username too long, must be less than 100 characters";
        $newUsername = strip_tags($this->username);
        if($newUsername !== $this->username)
            return "No special characters allowed in username";

        $stmt = $conn->prepare("SELECT username, address1, address2, mobile FROM users WHERE username = :username");
        $stmt->bindParam('username', $this->username);
        $result = $stmt->execute();
        if(!$result)
            return "Statement Failed: ". $stmt->errorInfo();
        return $stmt->fetch();
    }

    /**
     * Check if a user with the same username is already in the database
     * @param PDO $conn
     * @return string
     */
    public function checkUserExists($conn){
        if(strlen($this->username)>100)
            return "Username too long, must be less than 100 characters";
        $newUsername = strip_tags($this->username);
        if($newUsername !== $this->username)
            return "No special characters allowed in username";

        if($this->username == "")
            return "Invalid username";
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if(!$stmt) {
            return "Statement Failed: " . $stmt->errorInfo()[0];
        }elseif(!$result){
            return "NA";
        }
        return "Email already registered";
    }

    /**
     * Add user details to database
     * @param PDO $conn
     * @param string $password
     * @param string $address1
     * @param string $address2
     * @param string $mobile
     * @return string
     */
    public function createUser($conn, $password, $address1, $address2, $mobile){
        if(strlen($this->username)>100)
            return "Username too long, must be less than 100 characters";
        $newUsername = strip_tags($this->username);
        if($newUsername !== $this->username)
            return "No special characters allowed in username";
        if(strlen($address1)>254)
            return "Address too long, must be less than 254 characters";
        $newAddress = strip_tags($address1);
        if($newAddress !== $address1)
            return "No special characters allowed in address";
        if(strlen($address2)>254)
            return "Address too long, must be less than 254 characters";
        $newAddress = strip_tags($address2);
        if($newAddress !== $address2)
            return "No special characters allowed in address";
        if(strlen($mobile)>12)
            return "Mobile too long, must be less than 12 characters";
        $newMobile = strip_tags($mobile);
        if($newMobile !== $mobile)
            return "No special characters allowed in mobile";

        $userExists = $this->checkUserExists($conn);
        if($userExists == "NA") {
            $stmt = $conn->prepare("INSERT INTO users (username,password,address1,address2,mobile) VALUES (:username, :password, :address1, :address2, :mobile)");
            $stmt->bindParam('username', $this->username);
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam('password', $hashedPass);
            $stmt->bindParam('address1', $address1);
            $stmt->bindParam('address2', $address2);
            $stmt->bindParam('mobile', $mobile);
            $result = $stmt->execute();
            if(!$result){
                return "Statement Failed: ". $stmt->errorInfo();
            }else {
                return "Success";
            }
        }
        return $userExists;
    }

    /**
     * Change user details in the database
     * @param PDO $conn
     * @param string $password
     * @param string $address1
     * @param string $address2
     * @param string $mobile
     * @return string
     */
    public function editUser($conn, $password, $address1, $address2, $mobile){
        if(strlen($this->username)>100)
            return "Username too long, must be less than 100 characters";
        $newUsername = strip_tags($this->username);
        if($newUsername !== $this->username)
            return "No special characters allowed in username";
        if(strlen($address1)>254)
            return "Address too long, must be less than 254 characters";
        $newAddress = strip_tags($address1);
        if($newAddress !== $address1)
            return "No special characters allowed in address";
        if(strlen($address2)>254)
            return "Address too long, must be less than 254 characters";
        $newAddress = strip_tags($address2);
        if($newAddress !== $address2)
            return "No special characters allowed in address";
        if(strlen($mobile)>12)
            return "Mobile too long, must be less than 12 characters";
        $newMobile = strip_tags($mobile);
        if($newMobile !== $mobile)
            return "No special characters allowed in mobile";
        $stmt = $conn->prepare("UPDATE users SET password=:password,address1=:address1,address2=:address2,mobile=:mobile WHERE username=:username");
        $stmt->bindParam('username', $this->username);
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam('password', $hashedPass);
        $stmt->bindParam('address1', $address1);
        $stmt->bindParam('address2', $address2);
        $stmt->bindParam('mobile', $mobile);
        $result = $stmt->execute();
        if(!$result){
            return "Statement Failed: ". $stmt->errorInfo();
        }
        return "Success";
    }
    /**
     * Delete user from the database
     * @param PDO $conn
     * @return string
     */
    public function deleteUser($conn){
        if(strlen($this->username)>100)
            return "Username too long, must be less than 100 characters";
        $newUsername = strip_tags($this->username);
        if($newUsername !== $this->username)
            return "No special characters allowed in username";
        $stmt = $conn->prepare("DELETE FROM users WHERE username=:username");
        $stmt->bindParam('username', $this->username);
        $result = $stmt->execute();
        if(!$result){
            return "Statement Failed: ". $stmt->errorInfo();
        }
        return "Success";
    }

    /**
     * Compare password hashes for user
     * @param PDO $conn
     * @param string $password
     * @return bool|string
     */
    public function login($conn, $password){
        if(strlen($this->username)>100)
            return false;
        $newUsername = strip_tags($this->username);
        if($newUsername != $this->username)
            return false;

        $stmt = $conn->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if(!$stmt){
            return "Statement Failed: ".$stmt->errorInfo();
        }else{
            return password_verify($password, $result);
        }
    }

}