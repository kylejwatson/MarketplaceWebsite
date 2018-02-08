<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 07/11/17
 * Time: 14:53
 */

class User
{
    var $username = '';

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

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

    public function login($conn, $password){
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if(!$stmt){
            var_dump($stmt->errorInfo());
            die("Statement Failed: ".$stmt->errorInfo()[0]);
        }else{
            return password_verify($password, $result);
        }
    }

}