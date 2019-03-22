<?php

class Subject{
    
    private $conn;
    private $table_name = "subject";
    
    public $id;
    public $course_id;
    public $name;
    public $course_name;
    
//    public $created;
    
    function __construct($db){
        $this->conn = $db;
    }
    
    function add(){
            
        $query = "INSERT INTO ".$this->table_name." SET course_id=:course_id , name=:name";
        
        $stmt = $this->conn->prepare($query);
        
        $this->course_id =htmlspecialchars(strip_tags($this->course_id));
        $this->name =htmlspecialchars(strip_tags($this->name));
        
        
        $stmt->bindParam(":course_id",$this->course_id);
        $stmt->bindParam(":name",$this->name);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
        
    }
    
}

?>