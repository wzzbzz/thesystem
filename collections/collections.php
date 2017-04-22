<?php
require_once APP_ROOT."system/entities/entities.php";

class Item extends Entity{
    
    public function __construct($key,$home){
        parent::__construct($key,$home);
    }
    public function __destruct(){}
    
}

class Collection extends Entities{
    
    public function __construct($home, $key=null){
        parent::__construct($home,$key);
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
    
    public function count(){
        $collection = $this->get_collection();
        return count($collection);
    }
    
    public function add($entity){
        $this->link($entity);
    }
    
    public function find($key){
        return file_exists($this->self.$key);
    }
    
    public function in($_entity){
        
        $collection = $this->get_collection();
        $in = false;
        foreach($collection as $entity){
            $in = $in || ($entity = $_entity);
        }
        
        return $in;
    }
    
}
