<?php


class Recording extends Item{
        public $title;
        public $location;
        public $type;
        public $file;
        
        public function __construct($name = null, $path = null){
            parent::__construct($name,$path);
        }
        public function __destruct(){}
        public function render(){

            $method = "render_".$this->type;
            $this->$method();
        }
        
        public function render_embed(){
            $code = file_get_contents( $this->path."embed.code" );
            echo  '<h3>'.$this->title.'</h3>';
            echo '<div style="width:500px;">';
            echo $code;
            echo '</div>';
        }
        
        public function render_file(){
            
            $file = new File($this->name, $this->location);
            
            switch($file->mimetype()){
                    
            }
            
            
        }
        
        public function render_url(){
                
                $str = '<h3>'.$this->title.'</h3>';
                $str .= '<audio controls style="width:500px">
                    <source src="'.$this->location.'" type="audio/mp3">
                </audio>';
                
                echo $str;
        }
        
        public function save_embed($embed){
                $fh = fopen($this->path."embed.code","w");
                fwrite($fh,$embed);
                fclose($fh);
                return;
        }
        

}

class Recordings extends Collection{
        
        public function __construct($path){
            parent::__construct($path);
        }
        
        public function __destruct(){}
        public function get_recordings(){
            $_ = array();
            
            $keys = parent::get_collection($this->path);
            
            foreach($keys as $key){
               
                $recording = new Recording($key,$this->path);
                
                $_[] = $recording;
            }
            return $_;
        }
        
        public function add($recording){
            $recording->save();
        }
        

        
}
