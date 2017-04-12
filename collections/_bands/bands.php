<?php

require_once "system/collections/collections.php";
require_once "system/collections/_users/users.php";
require_once "system/collections/_songs/songs.php";

class Member extends User{
        
}

class Band {
    private $members;
    public $songs;
    public function __construct(){  
       
        $this->members = new Users(MEMBERS);
        $this->songs = new Songs();
    }
    public function __destruct(){

    }
    
    public function get_songs(){
        $_ = array();
        $songs = $this->songs->get_collection();
        foreach($songs as $songid){
            $_[] = new Song($songid);
        }
        return $_;
    }
    
    public function get_members(){
        return $this->members->get_collection();
    }
    
    public function create(){}
    public function delete(){}
}

class Bands extends Collections{
    
    private $members;
    private $songs;
    
    public function __construct($args=null){
        parent::__construct($args);
    }
    
    public function __destruct(){
        parent::__destruct();
    }
    
    public function get_bands(){
        return parent::get_collection(BANDS);
    }
        
}
