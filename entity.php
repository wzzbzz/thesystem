<?php

#what is the difference between a site and a system
#system > Site.
namespace thesystem;

class Entity extends \stdClass{

    //permanent elements
    public $key;  // relatively uniq within folder.
    public $source; // symlink to ENTITIES_ROOT/UNIQUID/  contains data.json
    
    // maintain list of references to this entity
    // when no links, entity "dies";
    public $links = []; // list of links to source entity
    
    // current symbolic path
    public function path(){
        return ENTITIES_ROOT.$this->branch().$this->name();
    }

    private $name;
    public function name(){
        return $this->name;
    }
    
    private $branch;
    public function branch(){        
        return (empty($this->branch))?"":rtrim($this->branch,"/")."/";
    }
    
    // now requiring : NAME and CONTEXT
    // NO GHOSTING
    // getting rid of create() step, either load or create new in memory.
    public function __construct( $name, $branch="", $load=true ){
        
        if(empty($name))
            return  false;

        $this->name = $name;
        $this->branch = $branch;        
        if(!$load){
            diebug(debug_backtrace());
        }
        if($load){
            $this->loadIfExistsElseCreate();
        }
        
    }

    public function loadIfExists(){
        
        if($this->exists()){

            $this->load();
        }
        else{
        }
    }

    public function createIfNonExistant(){
        if(!$this->exists()){

            $this->create();
        }
        else{
            
        }
    }

    public function loadIfExistsElseCreate(){

        if($this->exists()){
            $this->load();
        }
        else{
            
            $this->create();
            $this->link($this->path());

        }
    
    }
    public function exists(){
        return file_exists($this->path());
    }
    
    public function create(){
        
        $this->key = uniqid();
        $this->source = SOURCES_ROOT.$this->key."/";
        $this->links = array();
        mkdir($this->source);
        $this->save();
    }
    
    public function delete(){
        
        foreach($this->links as $i=>$link){
            
            unlink($link);
            unset($this->links[$i]);
            
            return;
        }
    }
    public function __destruct(){
        
        if(count($this->links)==0 && file_exists($this->source)){
            
                removeDirectory($this->source);
        }
        
    }

    public function save(){
       
        
        if(!file_exists($this->source)){
            return;
        }

        $filename = $this->source."info.json";
        
        $fh = fopen($filename,"w");
        
        fwrite($fh, json_encode($this));
        
        fclose($fh);
        
    }
      
    public function load(){
        
        // make sure we've got our trailing slash
        
        if(!file_exists($this->path())){
            return false;
        }

        $info = json_decode(file_get_contents($this->path()."/info.json"),true);
        
        if(empty($info))
            return;
        
        foreach($info as $key=>$value){
               $this->$key = $value;
        }
        

    }
    
    public function __exists(){
        //note:  handle this slash thing gracefully in constructors.
        $path = rtrim($this->path,"/")."/";
        return file_exists($path) && file_exists($path."info.json");
    }
    
    public function add_attribute($key,$val){
        $this->$key=$val;
    }
    
    public function remove_attribute($key){
        unset($this->$key);
    }

    public function get_attribute($key){
        return $this->$key;
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
            return;
        }
        if(array_search($dest,$this->links)!==false){
            return true; // TBD Error System.
        }
        
        try{
            symlink(rtrim($this->source,"/"), $dest);
        }
        catch(Exception $e){
            debug($dest);
            diebug(rtrim($this->source,"/"));
        }
        
        $this->links[] = $dest;
        $this->save();
        
        
    }
    
    public function unlink($dest){
  
        $item = array_search($dest,$this->links);
        
        if($item!==false){
            unlink($dest);
            unset($this->links[$item]);
            
            $this->save();
            
        }
        return;
    
            
        die("no");
    }
    
    public function container(){
        return (rtrim(str_replace(basename($this->path),"",$this->path),"/"));
    }
   
   
    public function get_uri(){
        return str_replace(APP_ROOT, BASEURL, $this->path);
    }
}

