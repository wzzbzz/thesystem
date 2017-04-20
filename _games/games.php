<?php
require_once "system/_users/users.php";

class Game extends Entity{
    
    #code
    public $players;
    public $admins;
    public $stages;  // for now an ENUM
    public $stage;
    public $states;
    public $state;
    
    public function __construct($key, $home, $args=null){
        parent::__construct($key,$home);
        $this->players = new Users("players",$this->self);
        $this->admins = new Users("admins", $this->self);
       
    }
    
    public function add_player($user){
        $this->players->add($user);
    }
    
    public function add_admin($user){
        $this->admins->add($user);
    }
    
    public function add_stages($stages){
        $this->stages = $stages; 
    }
   
    public function ready(){

        $ready= $this->__exists();
        
        $vars = get_object_vars($this);
       
        foreach( $vars as $var ){
            if( is_object( $var ) ){
                $ready = $ready && $var->exists();
            }
        }
        
        return true;
    }
    
    public function init($args=array()){
        foreach($args as $key=>$value){
            $this->$key = $value;
        }
    }
    
    
    public function destroy(){}
    
}

class Games extends Collection{
    
    public function __construct($home){
        parent::__construct($home);       
    }
    
    public function get_games(){
        $games = $this->get_collection();
        $_ = array();
        foreach($games as $game){
            $_[] = new Game($game, $this->self);
        }
        return $_;
    }
    
}


//class GameStage extends Entity{}
//class GameStages extends Entities{}
class GameState extends Entity{
    
    public $gameid;
    public $state;
    public $stage;
    
    public function __construct($key,$home){
        parent::__construct($key,$home);
        $this->requires = array(STATE=>STATEVALUE);
    }
}
class GamePlayer extends User{
    public $gamestate;
}
class GamePlayers extends Users{
    public function __construct($home){
        parent::__construct($home);
    }
}
class GameAdmins extends Users{
    
}
