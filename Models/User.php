<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 07/11/17
 * Time: 14:53
 */

class User
{
    var $username = '', $password = '';

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
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
        return "User exists";
    }

    public function createUser($conn, $address1, $address2, $mobile){
        $userExists = $this->checkUserExists($conn);
        if($userExists == "NA") {
            $stmt = $conn->prepare("INSERT INTO users (username,password,address1,address2,mobile) VALUES (:username, :password, :address1, :address2, :mobile)");
            $stmt->bindParam('username', $this->username);
            $hashedPass = password_hash($this->password, PASSWORD_DEFAULT);
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

    public function login($conn){
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if(!$stmt){
            var_dump($stmt->errorInfo());
            die("Statement Failed: ".$stmt->errorInfo()[0]);
        }else{
            return password_verify($this->password, $result);
        }
    }

}