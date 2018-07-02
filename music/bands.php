<?php

require_once APP_ROOT."system/music/songs.php";
require_once APP_ROOT."system/_records/records.php";

class Member extends User{
        
}

class Band extends Entity{
    public $members;
    public $songs;
    public $shows;
    public $albums;
    public $videos;
    public $site;
    public $manager;
    public $display_name;
    
    public function __construct($name, $path){
        parent::__construct($name,$path);
       
        $this->members = new Users($this->path,"members");
        $this->songs = new Songs($this->path);
        $this->albums = new Albums($this->path);
        $this->display_name = $this->name;

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
   
    
    public function __construct($path,$name){
        parent::__construct($path,$name);
    }

  
    public function get_bands(){
        $bands = $this->get_collection();
        $_ = array();
        foreach($bands as $key=>$band){
            $_[] = new Band($band,$this->path);
        }
        return $_;
    }
        
}
