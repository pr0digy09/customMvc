<?php 
class Pages{
    public function __construct(){
        echo 'Pages loaded';
    }

    public function index(){

    }
    
    public function about($id) {
        echo '<br> this is about with id ='.$id;
    }
}



?>