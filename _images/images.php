<?php

require_once APP_ROOT."system/collections/collections.php";

class Image extends Item{
        public $title;

        public function __construct($key = null, $home = null){
            parent::__construct($key,$home);
        }
        public function __destruct(){}
}

class Images extends Collection{
        
        public function __construct($path){
            parent::__construct($path);
        }
        
        public function __destruct(){}
        
        public function get_image(){
            $_ = array();
            
            $keys = parent::get_collection($this->self);
            
            foreach($keys as $key){
               
                $image = new Image($key,$this->self);
                
                $_[] = $image;
            }
            return $_;
        }
        
        public function add($image){
            $image->save();
        }
        

        
}
