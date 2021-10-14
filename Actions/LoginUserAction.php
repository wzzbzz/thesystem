<?php

namespace thesystem\Actions;


class LoginUserAction extends Action{
    public function do(){
        diebug($this->system_object->loginUser($_REQUEST['username'],$_REQUEST['password']));
    }
}