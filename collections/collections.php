<?php

class Item{
    
    public $key;  // locally unique identifier
    public $dir;  // container folder to which this item is attached
    public $path; // path to this item, its resources and info.json file
    
    public function __construct($key=null,$dir=null){

        $this->key = $key;
        $this->dir = $dir;
        
        $this->path = $dir.$key."/";
        
        if($this->exists()){
            $this->load();
        }
        
    }
    public function __destruct(){}
    
    public function save(){
        if (!$this->exists()){
            $this->create();
        }
        
        $filename = $this->path."/info.json";

        $fh = fopen($filename,"w");
        fwrite($fh, json_encode($this));
        fclose($fh);
        
    }
    
    public function create(){
        
        mkdir($this->path);

        $vars = get_object_vars($this);
       
        foreach($vars as $var){
            
            if("Collection" == get_parent_class($var)){
                $var->create();
            }
            
        }
        return true;
    }
    
    public function load(){
        
        $info = json_decode(file_get_contents($this->path."info.json"));

        foreach($info as $key=>$value){
            if(!is_object($value)){
               $this->$key = $value;
            }
        }

    }
    public function exists(){
        return file_exists($this->path);
    }  
    
}

class Collection{
    public $dir;
    public function __construct($dir){
        $this->dir = $dir."_".strtolower(get_class($this))."/";
    }
    public function __destruct(){}
    
    public function create(){
        if(!file_exists($this->dir))
            mkdir($this->dir);
    }
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