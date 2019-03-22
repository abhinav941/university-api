<?php

class Courses{
    
    private $conn;
    private $table_name = "courses";
    
    public $name;
    public $id;
    public $course_name;
//    public $created;
    
    function __construct($db){
        $this->conn = $db;
    }
    
    function read(){
        $query = "SELECT c.name as course_name ,s.name as subject_name,s.id as subject_id ,c.id FROM
        courses as c join subject as s on s.course_id=c.id where c.name=:course_name";
        
        $stmt = $this->conn->prepare($query);
        $this->course_name = htmlspecialchars(strip_tags($this->course_name));
        $stmt->bindParam(":course_name",$this->course_name);
        $stmt->execute();
        return $stmt;
    }
    function readSubject(){
        $query = "SELECT s.id as subject_id ,s.name as subject_name, c.name as course_name,c.id as course_id from               subject as s join courses as c on s.course_id = c.id where c.id =:id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id",$this->id);
        $stmt->execute();
        return $stmt;
    }
    
    function create(){
        $query = "INSERT INTO ".$this->table_name." SET name=:name ";
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        
        $stmt->bindParam(":name",$this->name);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    
    function extractId(){
        $query = "SELECT id from ".$this->table_name." WHERE name=:name";
        
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        
        $stmt->bindParam(":name",$this->name);
        
        $stmt->execute();
        return $stmt;
    }
    
}
?>