<?php 

class Student{
    
    private $conn;
    private $table_name = "students";
    
    public $id; 
    public $name; 
    public $courses_name; 
    public $gender; 
    public $DOB;
    public $roll_no;
    public $email;
    public $course_id;
    
    
    public function __construct($db){
        $this->conn = $db;
    }
    
    public function read(){
        $query = "SELECT 
                    c.name as course_name , s.id , s.name, s.roll_no ,s.email,s.gender,s.DOB ,s.course_id
                    FROM ".$this->table_name . " s
                     LEFT JOIN 
                        courses c
                        ON
                         s.course_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function create(){
        $query = "INSERT INTO ".$this->table_name." SET name=:name, course_id=:course_id , gender=:gender ,DOB=:DOB,roll_no=:roll_no,email=:email";
        
        $stmt = $this->conn->prepare($query);
        
        $this->name =htmlspecialchars(strip_tags($this->name));
        $this->course_id =intval(htmlspecialchars(strip_tags($this->course_id)));
        $this->gender =htmlspecialchars(strip_tags($this->gender));
        $this->roll_no =intval(htmlspecialchars(strip_tags($this->roll_no)));
        $this->DOB =htmlspecialchars(strip_tags($this->DOB));
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":course_id",$this->course_id);
        $stmt->bindParam(":DOB",$this->DOB);
        $stmt->bindParam(":roll_no",$this->roll_no);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":gender",$this->gender);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getStudent(){
        $query="SELECT c.name as course_name ,s.id,s.name,s.roll_no,s.DOB,s.gender,s.email,s.course_id FROM ".$this->table_name." s 
        LEFT JOIN 
         courses c 
        ON 
            s.course_id = c.id
        WHERE 
            s.roll_no = ?
        ";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1,$this->roll_no);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->name = $row['name'];
        $this->id = $row['id'];
        $this->roll_no = $row['roll_no'];
        $this->email = $row['email'];
        $this->course_name = $row['course_name'];
        $this->course_id = $row['course_id'];
        $this->gender = $row['gender'];
        $this->DOB = $row['DOB'];
    }
    function delete(){
        $query ="DELETE FROM ".$this->table_name."
                 WHERE id=?";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1,$this->id);
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function update(){
        $query = "UPDATE ".$this->table_name." SET     name=:name, course_id=:course_id ,               gender=:gender , DOB=:DOB ,                    roll_no=:roll_no,email=:email
        WHERE 
            id=:id
        " ;
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->course_id = htmlspecialchars(strip_tags($this->course_id));
        $this->DOB = htmlspecialchars(strip_tags($this->DOB));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->roll_no = htmlspecialchars(strip_tags($this->roll_no));
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        
        
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":id",$this->id);
        $stmt->bindParam(":gender",$this->gender);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":course_id",$this->course_id);
        $stmt->bindParam(":DOB",$this->DOB);
        $stmt->bindParam(":roll_no",$this->roll_no);
        
        
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
}
   function search($keywords){
        $query = "SELECT 
                    c.name as course_name , s.id , s.name, s.roll_no ,s.email,s.gender,s.DOB ,s.course_id
                    FROM ".$this->table_name . " s
                     LEFT JOIN 
                        courses c
                        ON
                         s.course_id = c.id
                    WHERE 
                        c.name LIKE ? OR s.name LIKE ? OR s.email LIKE ?
                    ";
        $stmt = $this->conn->prepare($query);
        
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        
        $stmt->bindParam(1,$keywords);
        $stmt->bindParam(2,$keywords);
        $stmt->bindParam(3,$keywords);
        $stmt->execute();
        return $stmt;
    }
}


?>