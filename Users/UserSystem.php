<?php

namespace thesystem\Users;

class UserSystem extends \thesystem\System{

    private $users;
    private $files;
    private $session;
    private $fileSystem;
    

    public function __construct($args=[]){
        
        parent::__construct();

        $this->setUsersRoot();
        $this->setFileSystem();
        $this->users = new \thesystem\Users\Users( "users", "", true);
        $this->fileSystem = new \thesystem\FileSystem($_SERVER['DOCUMENT_ROOT'], 'uploads');

        // universal index for files
        $this->files = new \thesystem\Files\Files('files', "", true);
        $this->session = new \thesystem\Session();
    }

    public function createSysop($email,$password){
        $user = new \thesystem\Users\User("sysop");
        $user->setEmail($email);
        $user->setPassword($password);
        return $user;
    }

    public function addUser($username){
        
        $user = new \thesystem\Users\User($username, $this->users->name());
        
        return $user;
    }

    public function getUser($username){
        
        $user = new User($username, $this->users->name());
        if($user->exists()){
            return $user;
        }
        else
            return false;
    
    }

    public function usersList(){
        return $this->users->get_users();
    }
    public function loginUser($username,$password){
        
        try{
            
            $user = $this->getUser($username);
            if(!$user || !$user->exists()){
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
            $fileinfo = $this->fileSystem->handleUpload($file);
        }
        $file_path = $fileinfo->file_name;
        diebug($_SERVER);
        $url = str_replace(WEB_ROOT,"",$file_path);

    }
    public function __destruct(){}
    public function init($path){
        
    }

}