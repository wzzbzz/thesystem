<?php
require_once "system/collections/collections.php";

class User extends Item{
    
    public $username;
    public $display_name;
    public $password;
    public $roles;
    
    public function __construct($args=null){
        
        if(!empty($args)){
            $this->username = $args['username'];
            $this->userdir = $this->dir.$this->username."/";
            $this->userfile = $this->userdir."info.json";
            if($this->exists()){
                $json = file_get_contents($this->userfile);
                $userdata = json_decode($json);
                $this->username = $userdata->username;
                $this->password = $userdata->password;
            }
        }
    }
    public function __destruct(){}
    
    public function get_username(){}
    public function set_username(){}
    
    public function get_display_name(){}
    public function set_user_name(){}
    
    public function add_role(){}
    public function delete_role(){}
    
    public function create(){}
    
    public function save(){}
    
    public function login(){}
    public function logout(){}
   
    public function exists(){
        return file_exists($this->userfile);
    }
    
    public function validate($password){             
        return password_verify($password, $this->password);
    }
}


class Users extends Collection{
    
    private $dir;
    
    public function __construct($dir=null){
        if(!empty($dir)){
            $this->dir = $dir;
        }
        else{
            $this->dir = $this->dir;
        }
    }
    
    public function get_users(){
        $users = array();
        $users_dir = new DirectoryIterator($this->dir);
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