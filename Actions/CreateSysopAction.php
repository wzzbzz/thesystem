<?php

namespace thesystem\Actions;

class CreateSysopAction extends Action{
    public function do(){
        $user = $this->system_object->createSysop( $_REQUEST['email'] , $_REQUEST['password'] );
        $this->system_object->addUser( $user->name() );
    }
}