<?php
    class Users extends Controller{
         public function __construct(){
            $this->userModel = $this->model('User');
         }
         
         public function register(){
             //check for POST
             if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //process from
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data=[
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confrim_password_err' => ''
               ];
               //validate email
               if(empty($data['name'])){
                   $data['name_err']= 'Please enter name';
               }

               if(empty($data['email'])){
                    $data['email_err']= 'Please enter your email';
                } else{
                    if($this->userModel->checkEmail($data['email'])){
                        $data['email_err']= 'This email is already taken';
                    }
                }

                if(empty($data['password'])){
                    $data['password_err']= 'Please enter password';
                } elseif(strlen($data['password'])< 6){
                    $data['password_err']= 'Password must be 6 or more characters';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err']= 'Please confirm password';
                } elseif($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err']= 'Passwords don\'t match';
                }

                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    //die('SUCCESS');
                } else{
                    $this->view('/users/register', $data);
                    die();
                }

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                //register user
                if($this->userModel -> register($data)){
                    redirect('/users/login');
                    //header('location: '.URLROOT .'/' . 'users/login');
                }else{
                    die('Something went wrong');
                }
            } else{
                 //load form
                 //echo 'load form';
                 $data=[
                     'name' => '',
                     'email' => '',
                     'password' => '',
                     'confirm_password' => '',
                     'name_err' => '',
                     'email_err' => '',
                     'password_err' => '',
                     'confrim_password_err' => ''
                ];

                //load view
                $this->view('users/register',$data);
             }
         }

         public function login(){
            //check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
               //process from
               $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data=[
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => ''
                ];

                if(empty($data['email'])){
                    $data['email_err']= 'Please enter your email';
                }

                if(empty($data['password'])){
                    $data['password_err']= 'Please enter password';
                } elseif(strlen($data['password'])< 6){
                    $data['password_err']= 'Password must be 6 or more characters';
                }
                
                if(empty($data['email_err']) && empty($data['password_err'])){
                    die('SUCCESS');
                } else{
                    $this->view('/users/login', $data);
                }

            } else{
                //load form
                //echo 'load form';
                $data=[
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];

               //load view
               $this->view('users/login',$data);
            }
        }
    }
?>