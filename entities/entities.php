<?php

class Entity {

    public $key;
    public $home;  // CONTAINING FOLDER
    public $self;
    
    
    public function __construct($key,$home){
        
        $this->key = $key;
        $this->home = $home;
        $this->self = $home.$key."/";
        
        if ($this->__exists()){
            $this->load();
        }
    }
    
    public function __destruct(){
        
    }
    
    public function create(){
        
        // fail if housing folder nonexistent.  Also check for write perms.
        
        if(!file_exists($this->home)){
            return false;
        }
        
        if(!file_exists($this->self))// create containing folder.
            mkdir($this->self);

        $vars = get_object_vars($this);
        
        // create ancillaries
        foreach($vars as $key=>$var){
            if(is_object($var)){
                $var->create();
            }            
        }
        
        $this->save();
        
        return true;
    }
    
    public function save(){
        
        $filename = $this->self."/info.json";

        $fh = fopen($filename,"w");
        
        fwrite($fh, json_encode($this));
        
        fclose($fh);
        
    }
      
    public function load(){
        
        if(is_link($this->self)){
            diebug("THIS WAS FORESEEN BUT UNABLE TO TRIGGER...UNTIL NOW!!! What happens when PHP won't follow the symlink?");
        }
        else{

            $info = json_decode(file_get_contents($this->self."info.json"));
        }
        if(empty($info))
            return;
        
        foreach($info as $key=>$value){
            if(!is_object($value)){
               $this->$key = $value;
            }
        }

    }
    
    public function __exists(){
        return file_exists($this->self) && file_exists($this->self."info.json");
    }
    
    
    
    // recursively determine whether an entity is of a class tree.
    public function is_class($class){
        if(get_class($this)==$class){
            return true;
        }
        $parent_class = get_parent_class($this);
        if(empty($parent_class)){
            return false;
        }
        $parent = new $parent_class($this->key, $this->home);
        return $parent->is_class($class);
    }
    
    
    // create a link at $destination which points to $this->self;
    public function link($destination){
        link($this->self, $destination);
    }
   
}

class Entities extends Entity{
    
    private $entities;
    
    public function __construct($home, $key=null){
        if(empty($key)){
            $key = "_".strtolower(get_class($this));

        }
        else{
            $key = "_".$key;
        }
        parent::__construct($key, $home);
    }
    
    public function __destruct(){}
    
    public function __create(){
        // make directory
        // extensions will create their own homes within it.
        parent::__construct($key);
        
    }
    
    public function link($entity){
        if(!file_exists($this->self.$entity->key)){
            symlink($entity->self, $this->self.$entity->key);
            return true;
        }
        else{
            return false;
        }
    }
}

