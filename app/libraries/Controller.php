<?php
/*
 *Base Controller
 * Loads the models and views
 */
 class controller{
     //load model
     public function model($model){
        //require model file
        require_once '../app/models/'. $model . '.php';

        //Instantiate model
        return new $model();

     }
     //load view
     public function view($view, $data = []){
        //check for the view file
        if(file_exists('../app/views/'. $view .'.php')){
            require_once '../app/views/'. $view .'.php';
        } else {
            die('View doesn\'t exist');
        }
     }
 }
?>