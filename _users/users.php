<?php

require_once "system/entities/entities.php";
require_once "system/collections/collections.php";

class User extends Entity{
    
    public $username;
    public $display_name;
    public $password;
    public $roles;
    
    public function __construct($key,$home){
        
        parent::__construct($key,$home);
        $this->username = $key;
        
    }
    
    public function login(){
        @session_start();
        $_SESSION['username'] = $this->username;
    }
    public function logout(){
        session_destroy();
    }
    public function set_password($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }
    public function validate($password){    
        return password_verify($password, $this->password);
    }
}


class Users extends Collection{
    
    public function __construct($home){
        parent::__construct($home);
    }
    
    public function get_users(){
        $users = parent::get_collection();
        $_ = array();
        foreach($users as $user){
            $_[] = new User($user, $this->self);
        }
        
        return $_;
    }
    
    public function user_exists($username){
        $user_dir = $this->self.$username;
        return (file_exists($user_dir) && is_dir($user_dir));
        
    }

    
    public function delete($username){
        if(!$this->user_exists($username)){
            return false;
        }
        else{
            removeDirectory($this->dir.$username);
        }
          
    }
   
    
    public function check_arguments($requires,$args){
        $valid=true;
        foreach($requires['variables'] as $variable){
            $valid = $valid && !empty($variable);
        }
        return $valid;
    }

    
    public function __destruct(){}
    
}