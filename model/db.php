<?php

class model
{
    /*
        This class is the connection to the database
    */
    protected static $mysqli;

    public function __construct(){
        $host = 'localhost'; //hostname
        $user = 'root'; //username
        $pass = ''; //password
        $db_name = 'dyuni'; //databaseName

        self::$mysqli = new mysqli($host,$user,$pass,$db_name);

        if (self::$mysqli->connect_error){
            die('Failed to connect to database');
        }else {
            //testing db connection
           // echo('connected'); 
        }
    }
}
