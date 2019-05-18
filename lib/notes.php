<?php

require_once APP_ROOT."system/entities.php";
require_once APP_ROOT."system/collections.php";

class Note extends Entity{
    private $file;
    public function __construct($name,$path){
        parent::__construct($name,$path);
        $this->file = $this->path.$this->name.".txt";
        if(!file_exists($this->file)){
            $fh = fopen($this->file,"w");
            fwrite($fh,"Add your lyrics");
            fclose($fh);
            
        }
    }
    
    public function get(){
        return trim(file_get_contents($this->file));
    }
    public function set($text){
        $fh = fopen($this->file,"w");
        fwrite($fh,$text);
        fclose($fh);
    }
    public function append($text){
        $fh = fopen($this->file,"a");
        fwrite($fh,"\r\n".$text);
        fclose($fh);
    }
    
    public function upload_file($file){
        $this->set(file_get_contents($file['tmp_name']));
    }
}

class Notes extends Collection {
    public function __construct($path,$name){
        parent::__construct($path,$name);
    }
}
