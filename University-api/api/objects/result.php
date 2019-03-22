<?php

class Result{
    
    private $conn;
    private $table_name = "result";
    
    public $id;
    public $student_id;
    public $course_id;
    public $subject_id;
    public $marks;
    public $roll_no;
    public $name;
    public $subject_name;
    public $course_name;
    
//    public $created;
    
    function __construct($db){
        $this->conn = $db;
    }
    
    function read(){
        $query = "SELECT
m.name,m.roll_no,m.marks,t.course_name,t.subject_name from 
(SELECT c.name as course_name,c.id as course_id ,sub.id as subject_id,sub.name as subject_name from courses as c join subject as sub on sub.course_id = c.id) as t join (SELECT s.name,r.subject_id as subject_id,s.roll_no,r.marks,r.course_id from result as r join students as s on s.id=r.student_id) as m on m.subject_id = t.subject_id where m.roll_no=:roll_no and t.course_name=:course_name;";
        $stmt = $this->conn->prepare($query);
        
        $this->roll_no = htmlspecialchars(strip_tags($this->roll_no)); 
        $this->course_name = htmlspecialchars(strip_tags($this->course_name));
        $stmt->bindParam(":roll_no",$this->roll_no);
        $stmt->bindParam(":course_name",$this->course_name);
        
        $stmt->execute();
        return $stmt;
    }
    function add(){
            
        $query = "INSERT INTO ".$this->table_name." SET course_id=:course_id , student_id=:student_id,subject_id=:subject_id,marks=:marks";
        
        $stmt = $this->conn->prepare($query);
        
        $this->course_id =htmlspecialchars(strip_tags($this->course_id));
        $this->student_id =intval(htmlspecialchars(strip_tags($this->student_id)));
        $this->marks =htmlspecialchars(strip_tags($this->marks));
        $this->subject_id =htmlspecialchars(strip_tags($this->subject_id));
        
        
        $stmt->bindParam(":course_id",$this->course_id);
        $stmt->bindParam(":student_id",$this->student_id);
        $stmt->bindParam(":subject_id",$this->subject_id);
        $stmt->bindParam(":marks",$this->marks);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
        
        
        
    }
    
}

?>