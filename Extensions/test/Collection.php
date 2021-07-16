<?php

namespace thesystem\contexts\test;

/*
    this is a test entity which merely implements the abstraction 
    with no added functionality
*/
class Collection extends \thesystem\Collection{

    public function __construct( $name = "", $path = "", $loadIfExists = false ){
        
        parent::__construct( $name , $path , $loadIfExists);
        
    }

}