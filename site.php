<?php
namespace thesystem;

class Site{
        
        public $admin;
        private $root_path;
        
        public function __construct(){}
        public function __destruct(){}
        
        public function addAdmin( $user ){
        }
        public function removeAdmin(){

        }
        public function is_admin(){
            if(!empty($this->admin))
                return $this->admin->key == $this->user->key;
            return false;
            
        }
        
        public function show_page($pagename){
            
            include APP_ROOT."templates/preamble.php";
            include APP_ROOT."templates/nav.php";
            include APP_ROOT."templates/$pagename.php";
            include APP_ROOT."templates/foot.php";
        }
        
        public function isInitialized(){
            debug(file_exists($root_path));
        }
    }
    