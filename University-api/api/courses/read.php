<?php 

//including header of the read file
header("Access-Control-Allow-Origin : * ");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Credentials:true");


//include the database connecting files
include_once '../config/database.php';
include_once '../objects/courses.php';

//instantiate database and product
$database = new Database();
$db = $database->getConnection();

//initialize the object
$courses = new Courses($db);

// we will created the read method for reading the student from the record 
// if $num>0 means record is there and we set reponse to 200 ok;
// the show the data using json file to user.

$data = json_decode(file_get_contents("php://input"));
//query products

if(!empty($data->course_name)){
    
    $courses->course_name = $data->course_name;
    $stmt = $courses->read();
    $num = $stmt->rowCount();
//check if more than 0 records ....
if($num>0){
    $student_arr = array();
    $student_arr["records"] = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $student_item=array(
            "subject_name"=>$subject_name,
            
        );
        array_push($student_arr["records"],$student_item);
        
    }
    
    http_response_code(200);
    
    echo json_encode($student_arr);    
}
    
else{
    http_response_code(404);
    
    echo json_encode(
    array("message"=>"No Courses Found."));}
}
else{
    http_response_code(400);
    
    echo json_encode(
    array("message"=>"Enter the data plz"));}



?>