<?php
/*
* PDO DB CLASS
* CONNECT to DATABASE
* Create prepared stmts
* Bind values
* Return results
*/

class Database{
    private $host = HOST;
    private $user = USER;
    private $password = PASSWORD;
    private $dbname = NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        //set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        //Cteare PDO Instance
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    
    //prepare stmt with querey

    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    //bind where clause
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;

                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    //execute the prepatred stmt
    public function execute(){
        return $this->stmt->execute();
    }

    // Get result set as array of OBJs
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //this will get single record
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }
}
?>