<?php
/*
* App Core Class
* Creates URL & loads core controller
* URL FORMAT - /controller/method/params
*/

class Core{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params =[];

    public function __construct(){
        //print_r($this ->getUrl());
        $url = $this ->getUrl();

        //look in controller for first value
        if(file_exists('../app/controllers/'. ucwords($url[0]).'.php')){
            //if exists, set as controller
            $this->currentController = ucwords($url[0]);
            //unset 0 index
            unset($url[0]);
        }

        // Require the current controller
        require_once '../app/controllers/'. $this->currentController. '.php';

        //Instantiate controller class
        $this->currentController = new $this->currentController;

        //check for second part of the url (methods)
        if(isset($url[1])){
            //check to see if method exists in the controller
            if(method_exists($this->currentController, $url[1])){
                //if exists, set as current method
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        //get params
        $this->params = $url ? array_values($url) : [];

        //call a callback with array of param
        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);

        //echo $this->currentMethod;
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }

    public function __destruct(){
    }
}


?>