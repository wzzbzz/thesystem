<?php

class Item{
    public $key;
    public $path;
    public $dir;
    public function __construct($key=null){
        $this->key = $key;
        
        if($this->exists()){
            $this->load();
        }
        
    }
    public function __destruct(){}
    
    public function save(){
        if (!$this->exists()){
            $this->create();
        }
        $filename = $this->dir."/info.json";

        $fh = fopen($filename,"w");
        fwrite($fh, json_encode($this));
        fclose($fh);
        
    }
    
    public function create(){
        debug($this->dir);
        mkdir($this->dir);
        $vars = get_object_vars($this);
       
        foreach($vars as $var){
            if("Collection" == get_parent_class($var)){
                $collection = "_".strtolower(get_class($var));
                $dir = $this->dir.$collection;
                mkdir($dir);
            }
            
        }
        return true;
    }
    
    public function load(){
        
        $info = json_decode(file_get_contents($this->dir."/info.json"));
        
        foreach($info as $key=>$value){
            if(!is_object($value)){
               $this->$key = $value;
            }
        }

    }
    public function exists(){
        return file_exists($this->dir);
    }  
    
}

class Collection{
    private $dir;
    public function __construct($dir){
        $this->dir = $dir;
    }
    public function __destruct(){}
    public function get_collection(){
        $_ = array();
        
        $items = new DirectoryIterator($this->dir);
        foreach($items as $item){
          if($item->isDir() && !$item->isDot()){
              $_[] = $items->__toString();
          }
          
        }
        return $_;
    }
    public function add($item){
        if(empty($item->key)){
            die("error");
        }
    }
}

class Collections{
    public function __construct($dir){
        $this->dir = $dir;
    }
    public function __destruct(){}
    
     public function get_collections($type){
        $_collections = array();
        $collections = new DirectoryIterator(USERDIR);
        foreach($collections as $collection){
          if($collection->isDot()){
              continue;
          }
          $_collections[] = $collection->__toString();
        }
        return $_collections;
    }
}