<?php

/*
*   
*
*/
namespace thesystem;

class System{
    
    // root Users collection;
    private $users;

    // admin user;
    private $admin;

    // router object for directing traffic to Actions or Views;
    private $router;

    // handles configuration
    private $config;

    // Probably not used since Router directly
    public $view;

    // currently logged in user
    public $current_user;


    /*
     *
     */ 
    public function __construct(){

        // load config object from doc root config.json
        $this->config = new \thesystem\Config\Config(json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/config.json")));
        
        $this->prepare();
        // is the system root in a valid location
           
    }

    /*
     *  These methods validate / prepare system setup
     */ 

    public function prepare(){

        if(!$this->config->validate()){
            die("bad config.");
        } 

        if( !file_exists( $this->references() ) ){
            mkdir($this->references());
        }
        
        if( !file_exists( $this->entities() ) ){
            mkdir($this->entities());
        }


    }

    /*
     *  helper functions for file paths
     */
    // return path to root
    public function root(){
        return $this->config->root();
    }

    // return path to references
    public function references(){
        return $this->root()."references/";
    }

    public function entities(){
        return $this->root()."entities/";
    }

    public function entitiesRoot(){

    }

    public function createEntity($name){
        
    }
    
    public function is_admin(){
        if(!empty($this->admin))
            return $this->admin->key == $this->user->key;
        
        return false;
        
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
    }
    public function __destruct(){}

    public function selfDestruct(){
        // obviously this will be a process which will require a One-Time-Key email password
        // validation routine;  but it's useful for development.

        removeDirectory(ENTITIES_ROOT);
        removeDirectory(SOURCES_ROOT);

        echo "boom.  it's gone";
        die;

    }
    
    public function setView(){
        
        $this->view = $router->getView($this);
    }

    public function routeRequest(){
        $router = new \thesystem\Router\Router($this);
        $router->routeRequest();
    }
    

    
}