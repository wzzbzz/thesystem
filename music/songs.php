<?php
require_once APP_ROOT."/system/recordings.php";
require_once APP_ROOT."/system/notes.php";

class Song extends Item{
    
    public $title;
    public $author;
    public $recordings;
    public $lyrics;
    
    public function __construct($name,$path){
        
        parent::__construct($name,$path);
        $this->lyrics = new Note("lyrics",$this->path);
        $this->recordings = new Recordings($this->path);
        
    }

    
}

class Songs extends Collection{

    public function __construct($home){
        parent::__construct($home);
    }
    
    public function __destruct(){}
    
    public function get_songs(){
        $keys = parent::get_collection();
        $_ = array();
        foreach($keys as $key){
            $song = new Song($key,$this->path);
            $_[] = $song;
        }
        return $_;
    }
   

}
