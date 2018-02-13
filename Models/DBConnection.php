<?php
/**
 * Created by PhpStorm.
 * User: Kylw
 * Date: 29/01/2018
 * Time: 16:25
 */

class DBConnection
{
    var $servername = "localhost";
    var $username = "stc905";
    var $password = "turtlebrainholocaust";
    var $dbname = "stc905";
    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct()
    {

    }

    public function connect(){
        try {
            // Create connection
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            // Check connection
        }catch(PDOException $e){
            die("Connection Error: ".$e->getMessage());
        }
    }

}