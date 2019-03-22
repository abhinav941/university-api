<?php 
header("Access-Control-Allow-Origin :*");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Headers:access");
header("Access-Control-Allow-Credentials:true");
header("Content-Type:application/json");

//including database and the product 
include_once '../config/database.php';
include_once '../objects/students.php';

//instantiate database
$database = new Database();
$connect = $database->getConnection();

//initialize the product
$student = new Student($connect);

//getting the id of the product to show
$student->roll_no  = isset($_GET['roll_no']) ? $_GET['roll_no'] : die();
$student->getStudent();

if($student->name!=null){
    $student_arr = array(
        "id"=>$student->id,
        "name"=>$student->name,
        "roll_no"=>$student->roll_no,
        "course_name"=>$student->course_name,
        "course_id"=>$student->course_id,
        "email"=>$student->email,
        "gender"=>$student->gender,
        "DOB"=>$student->DOB
    );
    http_response_code(200);
    
    echo json_encode($student_arr);
}
else{
    http_response_code(404);
    
    echo json_encode(array("message"=>"No Student found"));
}


?>