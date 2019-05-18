<?php

require_once APP_ROOT."/system/music/songs.php";

class Record extends Item{
    
    public $title;
    public $songs;
    public $lyrics;
    
    public function __construct($key,$home){
        parent::__construct($key,$home);

        $this->songs = new Songs($this->self);
        if($this->__exists()){
            $this->load();
        }
    }

    
}

class Album extends Collection{

    public function __construct($home){
        parent::__construct($home);
    }
    
    public function __destruct(){}
    
    public function get_songs(){
        $keys = parent::get_collection();
        $_ = array();
        foreach($keys as $key){
            $song = new Song($key,$this->self);
            $_[] = $song;
        }
        return $_;
    }
   

}

class Albums extends Collection{

    public function __construct($home){
        parent::__construct($home);
    }
    
    public function __destruct(){}
    
    public function get_albums(){
        $keys = parent::get_collection();
        $_ = array();
        foreach($keys as $key){
            $album = new Album($key,$this->self);
            $_[] = $album;
        }
        return $_;
    }
   

}
