<?php
require_once APP_ROOT."/system/collections/collections.php";

class Recording extends Item{
        public $title;
        public $location;
        public $type;
        public function __construct($key = null, $dir = null){
            parent::__construct($key,$dir);
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
                
            $url = str_replace(APP_ROOT, "", $this->path.$this->key);
            
            $fh = finfo_open(FILEINFO_MIME);
            $finfo = finfo_file($fh, $this->path.$this->key);
 
            if( strpos( $finfo , "audio" ) > -1 ){
                $str = '<h3>'.$this->title.'</h3>';
                $str .= '<audio controls style="width:500px">
                    <source src="'.BASEURL.$url.'" type="audio/mp3">
                </audio>';
                
                echo $str;
            }
        }
        

}

class Recordings extends Collection{
        
        public function __construct($path){
            parent::__construct($path);
        }
        
        public function __destruct(){}
        public function get_recordings(){
            $_ = array();
            $keys = parent::get_collection($this->dir);
            
            foreach($keys as $key){

                $recording = new Recording($key,$this->dir);
                
                $_[] = $recording;
            }
            return $_;
        }
        
        public function add($recording){
            $recording->save();
        }
        

        
}
