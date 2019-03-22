<?php 

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
header("Acces-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

//get database connection and get product object
include_once '../config/database.php';
include_once '../objects/students.php';

//instantiate database
$database =  new Database();
$connect = $database->getConnection();

//initiate student
$student =  new Student($connect);

//get posted data 
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->gender) && !empty($data->course_id) && !empty($data->DOB)&& !empty($data->roll_no)){
    $student->name=$data->name;
    $student->email=$data->email;
    $student->gender=$data->gender;
    $student->course_id=$data->course_id;
    $student->DOB = $data->DOB;
    $student->roll_no = $data->roll_no;
    
    if($student->create()){
        http_response_code(201);
        
        echo json_encode(array("message"=>"Student is succesfully Added","type"=>"success"));
        
    }
    else{
        http_response_code(503);
        
        echo json_encode(array("message"=>"Product unable to create","type"=>"danger"));
    }
}
else{
    http_response_code(400);
    
    echo json_encode(array("message"=>"data was incomplete","type"=>"danger"));
}
?>