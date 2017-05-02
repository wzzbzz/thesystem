<?php
require_once APP_ROOT."system/_users/users.php";

class Game extends Entity{
    
    #code
    public $players;
    public $admins;
    public $stages;  // for now an ENUM
    public $stage;
    public $states;
    public $state;
    public $player;
    
    public function __construct($key, $home){
        parent::__construct($key,$home);
        // proper way to do this is to create Players and Admins classes.
        $this->players = new Users($this->path,"players");
        $this->admins = new Users($this->path, "admins");
       
    }
    
    public function add_player($user){
        $this->players->add($user);
    }
    
    public function add_admin($user){
        
        if(!is_object($user)){
            $user = new User($user,$this->admins->path);
        }
        
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
    
    public function join($user){
        if(!is_object($user)){
            return false;
        }
        
        $this->add_player($user);
        
    }
    
    public function is_admin($user){
        //note this is a result of some slop upstream.
        //Code this away:   Make a decision, create objects earlier and store, or store keys and load objects on execution
        
        if (is_object($user)){
            
        }
        return $this->admins->in($user);
    }
    
     public function is_player($user){
        //note this is a result of some slop upstream.
        //Code this away:   Make a decision, create objects earlier and store, or store keys and load objects on execution
        
        if (is_object($user)){
            
        }
        return $this->players->in($user);
    }
    public function destroy(){}
    
}

class Games extends Collection{
    
    public function get_games(){
        $games = $this->get_collection();
        $_ = array();
        foreach($games as $game){
            $_[] = new Game($game, $this->path);
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
