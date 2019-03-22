<?php 

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
header("Acces-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

//get database connection and get product object
include_once '../config/database.php';
include_once '../objects/result.php';
include_once '../objects/courses.php';


//instantiate database
$database =  new Database();
$connect = $database->getConnection();

//initiate student
$result =  new Result($connect);
$course = new Courses($connect);
//get posted data 
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->course_id) && !empty($data->student_id) && !empty($data->marks)){
    
    
    $result->course_id=$data->course_id;
    $result->student_id=$data->student_id;
    $course->id = $data->course_id;
    
    $stmt = $course->readSubject();
    
    $num = $stmt->rowCount();
    $sid = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($sid,$row['subject_id']);
    }
    
    $marks = $data->marks;
    
    for($i=0;$i<count($marks);$i++){
        $result->marks=$marks[$i];
        $result->subject_id = $sid[$i];
        
        
        if($result->add()){
            http_response_code(201);
        
            echo json_encode(array("message"=>"Student is succesfully Added","type"=>"success"));
        
        }
        else{
            http_response_code(503);
        
            echo json_encode(array("message"=>"Product unable to create","type"=>"danger"));
        }    
    }
    
    
}
else{
    http_response_code(400);
    
    echo json_encode(array("message"=>"data was incomplete","type"=>"danger"));
}
?>