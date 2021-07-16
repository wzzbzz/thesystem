<?php

namespace thesystem\Users;

class UserSystem extends \thesystem\System{

    private $users;
    private $files;
    private $session;
    private $fileSystem;
    

    public function __construct($path,$args=[]){
        
        parent::__construct($path,$args=[]);
        $this->users = new \thesystem\Users\Users( "users", "", true);
        //$this->files = new \thesystem\Files\Files( "files", "", true);
        $this->fileSystem = new \thesystem\FileSystem(WEB_ROOT, 'uploads');
        $this->session = new \thesystem\Session();
    }

    public function addUser($username){
        
        $user = new \thesystem\Users\User($username, $this->users->name());
        
        return $user;
    }

    public function getUser($username){
        
        $user = new \thesystem\Users\User($username, $this->users->name(),false);
        
        if($user->exists()){
            $user->load();
            return $user;
        }
        else
            return false;
    
    }

    public function loginUser($username,$password){

        try{
            $user = $this->getUser($username);
            if(!$user->exists()){
                throw new \Exception();
            }
        }
        catch (\Exception $e){
            echo "User Not Found";
            return;
        }
        try{
            if(!$user->validatePassword($password)){
                throw new \Exception();
            }
        }
        catch(\Exception $e){
            echo "Invalid Password";
            return;
        }

        $this->session->setLoggedInUser($user->name());
        
    }

    public function logoutCurrentUser(){
        $this->session->clearUser();
    }

    public function hasLoggedInUser(){

    }
    public function currentUser(){
        if($this->session->loggedInUser()){
            $user =  $this->getUser($this->session->loggedInUser());
            return $user->exists()?$user:false;
        }
        else{
            return false;
        }
    }

    
    public function handleUpload(){
        foreach($_FILES as $file){
            $filepath = $this->fileSystem->handleUpload($file);
        }
    }
    public function __destruct(){}
    public function init($path){
        
    }
}