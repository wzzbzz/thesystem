<?php

namespace thesystem\Files;

class Files extends \thesystem\Collection{
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