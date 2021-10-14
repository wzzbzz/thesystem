<?php

namespace thesystem\Users;

class User extends \thesystem\Entity{
    
    public $display_name;
    public $password;
    public $path;
    public $files;
    private $email;

    public function __construct($name=null, $path=null, $load = true){
        parent::__construct($name, $path, $load);
        //$this->files = new Files($this->path,"files");
    }
    
    public function login(){
        @session_start();
        $_SESSION['username'] = $this->name;
    }
    
    public function logout(){
        session_destroy();
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setPassword($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $this->save();
    }
    public function validatePassword($password){
        diebug(password_verify($password,$this->password));
        return password_verify($password, $this->password);
    }
}
    
