<?php
require_once (APP_ROOT."system/collections/collections.php");

class File extends Entity{
        public $file_name;
        public $display_name;
        public $mime_type;
        public $description;
        
        public function __construct($name, $path){
                
                parent::__construct($name, $path,true);
                $this->display_name = $name;
        }
        
        public function __destruct(){
                parent::__destruct();
        }
        
        public function handle_upload($file){
            try {
    
                // Undefined | Multiple Files | $_FILES Corruption Attack
                // If this request falls under any of them, treat it invalid.
                if (
                    !isset($file['error']) ||
                    is_array($file['error'])
                ) {
                    throw new RuntimeException('Invalid parameters.');
                }
            
                // Check $file['error'] value.
                switch ($file['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }
            
                // You should also check filesize here. 
                if ($file['size'] > 1000000000) {
                    throw new RuntimeException('Exceeded filesize limit.');
                }
            
                // DO NOT TRUST $file['mime'] VALUE !!
                // Check MIME Type by yourself.
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                    $finfo->file($file['tmp_name']),
                    array(
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        'mp3' => 'audio/mpeg'
                    ),
                    true
                )) {
                    throw new RuntimeException('Invalid file format.');
                }
            
                // You should name it uniquely.
                // DO NOT USE $file['name'] WITHOUT ANY VALIDATION !!
                // On this example, obtain safe unique name from its binary data.
                $unique_name = sprintf('%s%s.%s',
                        $this->path,
                        $this->key,
                        $ext);
                if (!move_uploaded_file(
                    $file['tmp_name'],
                    $unique_name
                )) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }
                
                $this->file_name = $this->key.".".$ext;
                
                $this->save();
                
                return true;
            
            } catch (RuntimeException $e) {
            
                echo $e->getMessage();
            
            }

        }
        
        public function get_uri(){
                $uri = str_replace(APP_ROOT, BASEURL, $this->source).$this->file_name;
                return $uri;
        }
        
}
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