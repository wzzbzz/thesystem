<?php
namespace thesystem;

class FileSystem{
    private $path;
    public function __construct($root, $name="files"){
		
        if(!file_exists($root)){
            return false;
        }
        $root = rtrim($root,"/")."/";
        $this->path = $root.$name."/";
		
		if(!file_exists($this->path)){
			mkdir($this->path);
		}
        
    }

    public function handleUpload($file){

		try {
            
			// Undefined | Multiple Files | $_FILES Corruption Attack
			// If this request falls under any of them, treat it invalid.
			if (
				!isset($file['error']) ||
				is_array($file['error'])
			) {
				throw new \RuntimeException('Invalid parameters.');
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
				throw new \RuntimeException('Exceeded filesize limit.');
			}
		
			// DO NOT TRUST $file['mime'] VALUE !!
			// Check MIME Type by yourself.
			$finfo = new \finfo(FILEINFO_MIME_TYPE);
			$mime = $finfo->file($file['tmp_name']);
         
			if (false === $ext = array_search(
				$finfo->file($file['tmp_name']),
				$this->file_types(),
				true
			)) {
				throw new \RuntimeException('Invalid file format.');
			}
			// You should name it uniquely.
			// DO NOT USE $file['name'] WITHOUT ANY VALIDATION !!
			// On this example, obtain safe unique name from its binary data.
			$unique_name = sprintf('%s%s.%s',
					$this->path,
					uniqid(),
					$ext);

            
			if (!move_uploaded_file(
				$file['tmp_name'],
				$unique_name
			)) {
				throw new \RuntimeException('Failed to move uploaded file.');
			}
			$return = new \stdClass();
			$return->file_name = $unique_name;
			$return->mime_type = $file['type'];
		
			return $return;
		
		} catch (\RuntimeException $e) {
		
			echo $e->getMessage();
		
		}
	
	}

    public function file_types(){
		return array(
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'mp3' => 'audio/mpeg',
			"mp4" => 'video/mp4'
		);
	}

    public function __destruct(){}
}