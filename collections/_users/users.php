<?php
require_once "system/collections/collections.php";

class User extends Item{
    
    public $username;
    public $display_name;
    public $password;
    public $roles;
    
    public function __construct($key){
        
        parent::__construct($key,USERS);
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
    
    private $dir;
    
    public function __construct($dir=null){
      
    }
    
    public function get_users(){
        $users = parent::get_collection($this->dir);
        diebug($users);
        foreach($users_dir as $user_dir){
          if($user_dir->isDot()){
              continue;
          }
          $users[] = $user_dir->__toString();
        }
        return $users;
    }
    
    public function user_exists($username){
        $user_dir = $this->dir.$username;
        return (file_exists($user_dir) && is_dir($user_dir));
        
    }
    
    public function create($args=array()){
        if(empty($args['username'])){
            return false;
        }
        if($this->user_exists($args['username'])){
            return false;
        }
        else{
            $dir=$this->dir.$args['username'];
            mkdir($dir);
            $user = new stdClass();
            $user->username=$args['username'];
            $user->password=password_hash($args['password'], PASSWORD_DEFAULT, ['cost' => 12]);
            $fh = fopen ($dir."/info.json","w");
            fwrite($fh, json_encode($user));
            fclose($fh);
            return true;
        }
    }
    
    public function delete($username){
        if(!$this->user_exists($username)){
            return false;
        }
        else{
            removeDirectory($this->dir.$username);
        }
          
    }
    
    public function login($args){
        $requires = array("variables"=>array("username","password"),"filters"=>array("user_exists"=>array("username")));
        // check required vars
        
        if(!$this->check_arguments($requires,$args)){

            return false;
        }
        
        $user = new User(array("username"=>$args['username']));
        if ($user->validate($args['password'])){
            @session_start();
            $_SESSION['username'] = $args['username'];
            return true;
        }
        else{
            return false;
        }
    }
    
    public function check_arguments($requires,$args){
        $valid=true;
        foreach($requires['variables'] as $variable){
            $valid = $valid && !empty($variable);
        }
        return $valid;
    }
    
    public function logout_current(){
        
        if(session_id())
            session_destroy();
        return true;
    }
    
    public function __destruct(){}
    
}