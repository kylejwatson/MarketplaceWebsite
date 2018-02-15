<?php
/**
 * Created by PhpStorm.
 * User: Kylw
 * Date: 29/01/2018
 * Time: 16:25
 */

class DBConnection
{
    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public static function Instance(){

        $servername = "localhost";
        $username = "stc905";
        $password = "turtlebrainholocaust";
        $dbname = "stc905";
        static $inst = null;
        if($inst === null) {
            try {
                // Create connection
                $inst = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $inst->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Check connection
            }catch(PDOException $e){
                die("Connection Error: ".$e->getMessage());
            }
        }
        return $inst;
    }

    private function __construct()
    {

    }
}