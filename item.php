<?php

namespace thesystem;

class Item extends Entity{

    public function __construct($name,$path){
        parent::__construct($name,$path);
    }
    public function __destruct(){}
    
}