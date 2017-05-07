<?php

require_once APP_ROOT."system/entities/entities.php";


class Submission extends Entity{
    public $submitter;
    
    public function set_submitter($user){
        $user->link($this->path);
    }
    
    public function get_submitter(){
        die("return submitter");
    }
}
