<?php
require_once "system/_users/users.php";

class Player extends User{
    public $games;
    
    public function __construct($name=null, $home=null){
        $this->games = array();
        
        parent::__construct($name, $home);
        
    }
}

class Players extends Users{
    
    public function add($player){
        if(get_class($player)!="Player")
            $player = new Player($player->name, $player->container());
        parent::add($player);
    }
}

