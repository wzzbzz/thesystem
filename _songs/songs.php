<?php
require_once APP_ROOT."/system/entities/entities.php";
require_once APP_ROOT."/system/collections/collections.php";
require_once APP_ROOT."/system/_recordings/recordings.php";

class Song extends Item{
    
    public $title;
    public $author;
    public $recordings;
    public $lyrics;
    
    public function __construct($key,$home){
        parent::__construct($key,$home);

        $this->recordings = new Recordings($this->self);
        if($this->__exists()){
            $this->load();
        }
    }
    
    public function __destruct(){
        
    }
    
    public function delete(){
        
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
            $song = new Song($key,$this->self);
            $_[] = $song;
        }
        return $_;
    }
    
    public function add($song){
        
    }
    
    public function delete($key){
        
    }

}
