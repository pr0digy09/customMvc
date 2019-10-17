<?php
    class user{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }
        //register user
        public function register($data){
            $this->db->query('INSERT INTO USERS (NAME, EMAIL, PASSWORD) VALUES(:name, :email, :password)');
            $this->db->bind(':name',$data['name']);
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':password',$data['password']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
        public function checkEmail($email){
            $this->db->query("SELECT email FROM users where email = :email");
            $this->db->bind(':email', $email);

            $row=$this->db->single();
            if($this->db->rowCount()>0){
                return true;
            } else{
                return false;
            }
        }
    }

?>