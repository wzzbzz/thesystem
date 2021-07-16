<?php

namespace thesystem\Extensions\test;

/*
    this is a test entity which merely implements the abstraction 
    with no added functionality
*/
class Entity extends \thesystem\Entity{

    public function __construct( $name = "", $path = "", $loadIfExists = true ){
        
        parent::__construct( $name , $path , $loadIfExists);
        
    }

}