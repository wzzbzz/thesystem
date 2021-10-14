<?php
namespace thesystem\Config;



class Config{

    // object from config file
    private $data;

    public function __construct($data){
        $this->data=$data;
    }

    // root path of symlink tree
    public function root(){
        return rtrim( $this->data->root , "/" ) . "/";
    }

    // check configuration for runnability
    public function validate(){
        return is_writeable($this->data->root);
    }
}