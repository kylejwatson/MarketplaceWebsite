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
     * Check if a user with the same username is already in the database
     * @param PDO $conn
     * @return string
     */
    public function checkUserExists($conn){
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
     * Compare password hashes for user
     * @param PDO $conn
     * @param string $password
     * @return bool|string
     */
    public function login($conn, $password){
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