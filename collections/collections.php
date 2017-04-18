<?php
require_once "system/entities/entities.php";

class Item extends Entity{
    
    public function __construct($key,$home){
        parent::__construct($key,$home);
    }
    public function __destruct(){}
    
}

class Collection extends Entities{
    
    public function __construct($home){
        parent::__construct($home);
    }
    
    public function __destruct(){}
    
    public function get_collection(){
        $_ = array();
 
        $items = new DirectoryIterator($this->self);
        foreach($items as $item){
          if($item->isDir() && !$item->isDot()){
              $_[] = $item->__toString();
          }
          
        }
        return $_;
    }
    
    public function add($entity){
        if(empty($item->key)){
            die("error");
        }
    }
    
    public function find($key){
        return file_exists($this->self.$key);
    }
    
    public function load(){
        return;
    }
    
}
