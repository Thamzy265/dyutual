<?php

require_once __DIR__ . '/../helpers/env.php';

class model
{
    /*
        This class is the connection to the database.
        The credentials come from the file `.env` in the root folder.
        Read the file `.env.example` for the list of the keys.
    */
    protected static $mysqli;

    public function __construct(){
        $host    = env('DB_HOST', 'localhost');     //hostname
        $user    = env('DB_USERNAME', 'root');      //username
        $pass    = env('DB_PASSWORD', '');          //password
        $db_name = env('DB_DATABASE', 'dyuni'); //databaseName
        $port    = (int) env('DB_PORT', 3306);      //port

        self::$mysqli = new mysqli($host,$user,$pass,$db_name,$port);

        if (self::$mysqli->connect_error){
            die('Failed to connect to database');
        }else {
            //testing db connection
           // echo('connected'); 
        }
    }
}
