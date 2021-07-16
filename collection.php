<?php
namespace thesystem;

class Collection extends Entity implements \Countable{
    
    public function __construct($name, $path=null, $load){
        
        
        if(empty($name)){
            $name = "_".strtolower(get_class($this));

        }
        else{
            $name = "_".$name;
        }
        
        parent::__construct($name, $path, $load);
        
        $this->save();

    }
    
    public function get_collection(){
        $_ = array();
        
        $items = new \DirectoryIterator($this->path());
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
            $this->link($this->path());
            $this->save();
        }
        return $result;
    }
    
    public function count(){

        $collection = $this->get_collection();

        return count($collection);
    }
    
    public function add($entity){
        
        $link = rtrim($this->path(),"/")."/".$entity->name(); 
        
        $entity->link($link);
        
    }
    
    public function remove($entity){
        
        
        
        if(is_string($entity)){
            $link = rtrim($this->path(),"/")."/".$entity;
        }
        else{
            $link = rtrim($this->path(),"/")."/".$entity->name();
        }            
        
        $entity->unlink($link);
        
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

            $in = $in || ($entity == $_entity->name);
        }
        
        return $in;
    }
    
    
    public function random(){
        $c = $this->get_collection();
        $item = array_rand($c);
        
        return $c[$item];
    }
    
    
}
