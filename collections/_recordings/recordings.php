<?php
require_once "system/collections/collections.php";

class Recording extends Item{
        public $title;
        public $location;
        public $type;
        public function __construct($key = null){
            $this->key = $key;
            parent::__construct($key);
        }
        public function __destruct(){}
        public function render(){
            $method = "render_".$this->type;          
            $this->$method();
        }
        
        public function render_embed(){
            $code = file_get_contents( $this->path."embed.code" );
            echo  '<h3>'.$this->title.'</h3>';
            echo $code;
        }
        
        public function render_file(){
            $url = str_replace(APP_ROOT, "", $this->path);
            $fh = finfo_open(FILEINFO_MIME);
            $finfo = finfo_file($fh, $this->path);
            if( strpos( $finfo , "audio" ) > -1 ){
                $str = '<h3>'.$this->title.'</h3>';
                $str .= '<audio controls style="width:500px">
                    <source src="'.$url.'" type="audio/mp3">
                </audio>';
                
                echo $str;
            }
        }
}

class Recordings extends Collection{
        
        public function __construct($path){
            $this->dir = $path."_recordings/";
            parent::__construct($this->dir);
                
        }
        
        public function __destruct(){}
        public function get_recordings(){
            $_ = array();
            $keys = parent::get_collection($this->dir);

            foreach($keys as $key){
                
                $recording = new Recording($key);
                $recording->dir = $this->dir.$key;
                $recording->load();
                $_[] = $recording;
            }
            return $_;
        }
        
        public function add($recording){
            $recording->path = $this->dir.$recording->key."/";
            $recording->save();
        }
        

        
}
