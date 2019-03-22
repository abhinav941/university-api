<?php 

header("Access-Control-Allow-Origin:*");
header("Acces-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
header("Access-Control-Allow-Methods:POST");
header("Content-Type:application/json");
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Max-Age:3600");

//include databse and product
include_once "../config/database.php";
include_once "../objects/students.php";

//instantiate database
$database =new Database();
$connect = $database->getConnection();


//initiate the product
$student = new Student($connect);


$data = json_decode(file_get_contents("php://input"));
$student->id = $data->id;

if($student->delete()){
    http_response_code(200);
    
    echo json_encode(array("message"=>"Student is deleted","type"=>"success"));
    
}
else{
    http_response_code(503);
    
    echo json_encode(array("message"=>"Student data can't be deleted","type"=>"danger"));
}
?>