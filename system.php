<?php

namespace thesystem;

class System{
    
    private $users;
    private $admin;
    public $user;
    protected $root;
    
    public function __construct($path,$args=[]){
        
        if(!is_writeable($path)){
            die("bad config.");
        }
        
        $path = rtrim($path,"/")."/";
        $sources_root = (isset($args['sources_root']))?$args['sources_root']:'sources';
        $entities_root = (isset($args['entities_root']))?$args['entities_root']:'entities';
        $this->root = $path;

        define("SOURCES_ROOT",$path."sources/");
        if(!file_exists(SOURCES_ROOT)){
            mkdir(SOURCES_ROOT);
        }
        define("ENTITIES_ROOT",$path."entities/");

        if(!file_exists(ENTITIES_ROOT)){
            mkdir(ENTITIES_ROOT);
        }
    }

    public function createEntity($name){
        
    }
    
    public function is_admin(){
        if(!empty($this->admin))
            return $this->admin->key == $this->user->key;
        
        return false;
        
    }
    
    public function login_user($username,$password){
        // validate input!
        
        if(!$this->users->user_exists($username)){
            die("do a bad user thing");
        }
        
        $user = new User($username,$this->users->path);
        
        if($user->validate($password)){
            @session_start();
            $_SESSION['username'] = $username;
            return true;
        }
        
        
        return false;
    }
    
    
    public function is_logged_in_user($username){
        if(!empty($_SESSION['username'])){
            if($this->users->user_exists($_SESSION['username'])){
                $this->user = new User($_SESSION['username'], $this->users->path);
            }
        }
        return $username==$_SESSION['username'];
    }
    
    
    // establish a session username using PHP sessions.
    public function establish_session(){
         
        if(!empty($_SESSION['username'])){
    
            if($this->users->user_exists($_SESSION['username'])){
                
                // set current user for objects
                $this->user = new User($_SESSION['username'], $this->users->path);
        
            }
        }
    }
    
    // over ride on object levels
    public function system_slug($str){
        
        return str_replace(" ","-",strtolower($str));

    }
    
    public function isInitialized(){
        return file_exists($this->entities_root()) && is_writeable($this->entities_root());
    }

    public function entities_root(){
        return $this->root. "entities";
    }

    public function initialize(){
        $this->createEntitiesRoot();
        $this->users = new Users($this->entities_root());
        diebug($this->users);
    }

    private function createEntitiesRoot(){
        mkdir($this->root."entities");
        define('ENTITIES_ROOT',$this->root."entities");
    }
    public function __destruct(){}
    
    
}