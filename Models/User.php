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
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if(!$stmt){
            var_dump($stmt->errorInfo());
            die("Statement Failed: ".$stmt->errorInfo()[0]);
        }else{
            return $this->username == $result;
        }
    }

    public function createUser($conn){
        // prepare and bind
        if($this->checkUserExists($conn)){
            return false;
        }else{
            $stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (:username, :password)");
            $stmt->bindParam('username', $this->username);
            $hashedPass = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam('password', $hashedPass);

            $result = $stmt->execute();
            if(!$result){
                die("Statement Failed: ". $stmt->errorInfo());
            }else {
                return "Success";
            }
        }
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