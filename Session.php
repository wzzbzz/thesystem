<?php
namespace thesystem;

class Session{
    public function __construct(){
        @session_start();
    }
    public function __destruct(){

    }
    public function setLoggedInUser($username){
        $_SESSION['username'] = $username;
    }
    public function isLoggedInUser($username){
        return $_SESSION[ 'username' ] == $username;
    }
    public function loggedInUser(){
        return isset( $_SESSION['username'] ) && !empty( $_SESSION['username'] ) ? $_SESSION['username'] : false;
    }
    public function clearUser(){
        unset($_SESSION[ 'username' ]);
    }

}