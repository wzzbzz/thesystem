<?php
namespace thesystem\Users;

class Users extends \thesystem\Collection{
    
    public function __construct( $name, $path, $load=true ){
        parent::__construct($name, $path, $load);
        
    }
    public function get_users(){
        $users = parent::get_collection();
        $_ = array();
        foreach($users as $user){
            $_[] = new User($user, $this->path);
        }
        
        return $_;
    }
    
    public function create_user($name){
        if($this->user_exists($name)){
            $user = new User($name);
            return $this->load($this->path);
        }
    }
    
    public function user_exists($username){
        
        if(is_object($username)){
            $username= $username->username;
        }
        
        $user_dir = $this->path.$username;
        
        return (file_exists($user_dir) && is_dir($user_dir));
        
    }

    
    public function delete_1($username){
        if(!$this->user_exists($username)){
            return false;
        }
        else{
            removeDirectory($this->dir.$username);
        }
          
    }
}