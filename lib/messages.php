<?php


require_once "entities.php";
require_once "collections.php";
require_once "users.php";
require_once "notes.php";

class Message extends Note{
    public $from;
    public $to;
    public $subject;
    public $message;
    public $status;  // read, unread.
    
    public function __construct($path,$name){
        parent::construct($path,$name);   
    }
    
    
}

class Messages extends Collection{
    
    public function __construct($name,$path){
        parent::__construct($name,$path);
    }
        
}