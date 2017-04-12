<?php
require_once "system/collections/collections.php";
require_once "system/collections/_recordings/recordings.php";

##TBD extend from container
class Song extends Item{
    public $title;
    public $author;
    public $recordings;
    public $lyrics;
    
    public function __construct($key=null){
        parent::__construct($key,SONGS);
        $this->recordings = new Recordings($this->dir);
        if($this->exists()){
            $this->load();
        }
    }
    
    public function __destruct(){
        
    }
    
    public function delete(){
        
    }
    
}

class Songs extends Collection{

    public function __construct(){
        parent::__construct(SONGS);
    }
    public function __destruct(){}
    
    public function get_songs(){
        $keys = parent::get_collection();
        $_ = array();
        foreach($keys as $key){
            $song = new Song($key);
            $_[] = $song;
        }
        return $_;
    }
    
    public function add($song){
        
    }
    
    public function delete($key){
        
    }

}
