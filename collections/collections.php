<?php
require_once APP_ROOT."system/entities/entities.php";

class Item extends Entity{
    public $path;
    
    public function __construct($key,$home){
        parent::__construct($key,$home);
    }
    public function __destruct(){}
    
}

class Collection extends Entity implements Countable{
    
    public $path;
    
    public function __construct($path, $name=null){
        
        
        if(empty($name)){
            $name = "_".strtolower(get_class($this));

        }
        else{
            $name = "_".$name;
        }
        
        parent::__construct($name, $path);
        
        $this->path = rtrim($path,"/")."/".$name;
        
        $this->save();

    }
    
    public function get_collection(){
        $_ = array();
        
        $items = new DirectoryIterator($this->path);
        foreach($items as $item){
          if($item->isDir() && !$item->isDot()){
              $_[] = $item->__toString();
          }
          
        }
        return $_;
    }
    
    public function create(){
        
        $result = parent::create();
        
        if($result){
            $this->link($this->path);
            $this->links[]=$this->path;
            $this->save();
        }
        return $result;
    }
    
    public function count(){
        $collection = $this->get_collection();
        return count($collection);
    }
    
    public function add($entity){
        
        $link = rtrim($this->path,"/")."/".$entity->name;
        
        $entity->link($link);
        
    }
    
    //not a proper execution of find;
    public function find($key){
        return file_exists($this->self.$key);
    }
    
    // require objects
    public function in($_entity){
        
        $collection = $this->get_collection();
        $in = false;
        foreach($collection as $entity){
            $in = $in || ($entity == $_entity->key);
        }
        
        return $in;
    }
    
    
    public function add_2($entity){
        $this->link($entity);
        $entity->links[] = $entity->home;
        
    }
    
    
}
