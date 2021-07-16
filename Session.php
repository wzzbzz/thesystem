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
        return $_SESSION['username'] == $username;
    }
    public function loggedInUser(){
        return $_SESSION['username'];
    }
    public function clearUser(){
        unset($_SESSION['username']);
    }

}