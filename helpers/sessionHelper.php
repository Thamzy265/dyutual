<?php

class sessionHelper
{
    function __construct()
    {
        session_start();
    }

    public function setSession($key,$value){
        $_SESSION[$key] = $value;
    }

    public static function getSession($key){

        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }
    public function clearAllSessions(){
        session_unset();

        session_destroy();
    }
    public function isNotLogged(){
        if (!isset($_SESSION['dyunilog'])){
            header('location: /dyuni/index.php');
        }
    }

    public function isLogged(){
        if (isset($_SESSION['dyunilog'])){
            header('location: /dyuni/views/?page=home');
        }
    }
}