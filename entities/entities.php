<?php


class System{
    
    public function __construct($path){
        // validate path as a valid system root
        if(!file_exists($path)){
            // can specify alternate paths
            // deal with it then.
        }
        
        define("SYSTEM_ROOT",rtrim($path,"/")."/");
        define ("ENTITIES_ROOT", $path."_entities/");
        
    }
    
}

class Entity {

    //permanent elements
    public $key;  // relatively uniq
    public $source; // container for link
   
    // maintain list of references to this entity
    // when no links, entity "dies";
    public $links; // list of links to source entity 
    
    
    // now requiring : NAME and CONTEXT
    // NO GHOSTING
    // getting rid of create() step, either load or create new in memory.
    public function __construct($name=null,$path=null){
        
        // check for existing entity at path:
        if($path && $name){
            
            if(!file_exists($path)){
                return false;
            }
            
            $path = rtrim($path,"/")."/";
            $key = $path.$name;
    
            if(file_exists($key)){
                
                $this->load($key);
                
                return;
            }
            
            else{
                $this->create();
                $this->name = $name;
                $this->save();
                $this->link($key);
            }

        }
        
        else{
            $this->create();
            $this->name = $name;
            $this->save();
        }
        
    }
    
    public function create(){
         $this->key = uniqid();
         $this->source = ENTITIES_ROOT.$this->key."/";
         $this->links = array();
         mkdir($this->source);
    }
    
    public function __destruct(){

        if(count($this->links)==0 && file_exists($this->source)){
            if(strpos($this->source, APP_ROOT)>-1)
                removeDirectory($this->source);
        }
        
    }

    public function save(){
        
        $filename = $this->source."info.json";

        $fh = fopen($filename,"w");
        
        fwrite($fh, json_encode($this));
        
        fclose($fh);
        
    }
      
    public function load($path){
        
        // make sure we've got our trailing slash
        $path = rtrim($path,"/")."/";
        
        if(!file_exists($path)){
            return false;
        }
        
        $info = json_decode(file_get_contents($path."info.json"));
        
        if(empty($info))
            return;
        
        foreach($info as $key=>$value){
            if(!is_object($value)){
               $this->$key = $value;
            }
        }

    }
    
    public function __exists(){
        return file_exists($this->path) && file_exists($this->path."info.json");
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
    
    
    // create a link at $destination which points to $this->home;
    public function link($dest){
        
        // existing link - figure out how to resolve conflict
        if (file_exists($dest)){
            return false;
        }
        symlink(rtrim($this->source,"/"), $dest);
        $this->links[] = $dest;
        $this->save();
        
    }
   
}

