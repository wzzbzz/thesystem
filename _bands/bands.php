<?php

require_once APP_ROOT."system/collections/collections.php";
require_once APP_ROOT."system/_users/users.php";
require_once APP_ROOT."system/_songs/songs.php";
require_once APP_ROOT."system/_records/records.php";

class Member extends User{
        
}

class Band extends Entity{
    private $members;
    public $songs;
    public $shows;
    public $albums;
    public $videos;
    public $site;
    public $manager;
    public function __construct($key='band', $home=APP_ROOT){
        parent::__construct($key,$home);
        //$this->members = new Users(MEMBERS);
        $this->songs = new Songs($this->path);
        $this->albums = new Albums($this->path);

    }
    public function __destruct(){

    }
    
    public function get_songs(){
        $_ = array();
        $songs = $this->songs->get_songs();
        $songs = $this->songs->get_collection();
        foreach($songs as $songid){
            $_[] = new Song( $songid,$this->songs->path );
        }
        return $_;
    }
    
    public function add_song(){
        
    }
    
    public function get_members(){
        return $this->members->get_collection();
    }

    public function delete(){}
    
}

class Bands extends Collection{
   
    
    public function __construct($args=null){
        parent::__construct($args);
    }

  
    public function get_bands(){
        return parent::get_collection();
    }
        
}
