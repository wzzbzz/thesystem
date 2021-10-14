<?php

namespace thesystem\Router;

class Router{

    private $system_object;
    private $path;

    private $actions_classes = [

    ];

    public function __construct($system_object){
        $this->system_object = $system_object;
        $this->path=trim(parse_url($_GET['request_uri_path'])['path'],"/");

        // use constructor to sanitize request;
    }

    public function __destruct(){}

    public function routeRequest( ){

        
        if($this->isAction()){
            $this-doAction();
        }

        switch ($parts[0]){
            case "signup":
                $view = new \thesystem\Views\SignupView($this->system_object);
                
                break;
            case "login":
                $view =  new \thesystem\Views\LoginView($this->system_object);
                
                break;
            case "actions":
                
                switch ($parts[1]){
                    case "LoginUser":                    
                        $action = new \thesystem\Actions\LoginUserAction($this->system_object);
                    break;
                    case "CreateSysop":
                        $action = new \thesystem\Actions\CreateSysopAction($this->system_object);
                        break;
                    default:
                    break;
                }
                break;
            default:
                return new \thesystem\Views\View($this->system_object);
                break;
        }

        // If there are no users, you will be prompted to make the sysop
        if(empty($this->system_object->usersList())){
            $view = new \thesystem\Views\AdminSetupView($this->system_object);
        }


        if ($action){
            $action->do();
        }

        if ($view){
            $view->render();
        }
        
    }

    public function isAction(){
        $parts = explode("/",$this->path);
        return $parts[0]=="actions";
    }

    public function doAction(){
        $parts = explode("/",$this->path);
        $action_name = $parts[1];
        $className = "\thesystem\Actions\{$actionName}Action";
        $action_object = new $className($this->system_object);
        diebug($action_object);
    }


    private function parseRequest(){
        
        
    }
    
}