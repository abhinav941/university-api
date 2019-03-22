<?php

class Admin{
    
    private $conn;
    private $table_name = "admin";
    
    public $username;
    public $id;
    public $password;
//    public $created;
    
    function __construct($db){
        $this->conn = $db;
    }
    
    function read(){
        $query = "SELECT id,username,password FROM
         ". $this->table_name ."
            where username=:username and password=:password";
     
        $stmt = $this->conn->prepare($query);
        
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":password",$this->password);
        
        $stmt->execute();
        return $stmt;
    }
}
?>