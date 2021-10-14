<?php
namespace thesystem\Actions;

class Action{
    protected $system_object;
    public function __construct($system_object){
        $this->system_object = $system_object;
    }

    public function do(){
        
    }
}