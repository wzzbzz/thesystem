<?php
require_once APP_ROOT."/system/collections/collections.php";
require_once APP_ROOT."/system/collections/_recordings/recordings.php";


class Song extends Item{
    public $title;
    public $author;
    public $recordings;
    public $lyrics;
    
    public function __construct($key=null, $dir=SONGS){
        parent::__construct($key,$dir);
        
        $this->recordings = new Recordings($this->path);
       
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

    public function __construct($path){
        parent::__construct($path);
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
