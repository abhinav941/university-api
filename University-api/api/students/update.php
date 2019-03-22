<?php 
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Methods:POST");

//include database and products object
include_once '../config/database.php';
include_once '../objects/students.php';

//instantiate the database object
$database = new Database();
$connect = $database->getConnection();

//inititate the product 
$student = new Student($connect);

//get the data that is being modified
$data = json_decode(file_get_contents("php://input"));

$student->id = $data->id;
$student->name = $data->name;
$student->email = $data->email;
$student->roll_no = $data->roll_no;
$student->gender = $data->gender;
$student->course_id = $data->course_id;
$student->DOB = $data->DOB;



if($student->update()){
    http_response_code(200);
    
    echo json_encode(array("message"=>"Data is succesfully updated"));
    
}

else{
    http_response_code(503);
    
    echo json_encode(array("message"=>"Data is no modified"));
}

?>