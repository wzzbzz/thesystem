<?php

namespace thesystem;

class Files extends Collection{
    public function __construct($path, $name){
        parent::__construct($path, $name);
        
    }
    public function __destruct(){}
    
    // takes an element from the $_FILES array
    public function add_uploaded_file($upfile){
        $file = new File($upfile['name'],$this->path);
        $file->handle_upload($upfile);
    }
    
   public function get_files(){
            $_ = array();
            $keys = parent::get_collection();
            foreach($keys as $key){
                
                $file = new File($key,$this->path);
                $_[] = $file;
                
            }
            return $_;
        }
}