<?php 

//including header of the read file
header("Access-Control-Allow-Origin : * ");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Credentials:true");


//include the database connecting files
include_once '../config/database.php';
include_once '../objects/result.php';

//instantiate database and product
$database = new Database();
$db = $database->getConnection();

//initialize the object
$result = new Result($db);

// we will created the read method for reading the student from the record 
// if $num>0 means record is there and we set reponse to 200 ok;
// the show the data using json file to user.

//query products
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->roll_no) && !empty($data->course_name)){
    $result->roll_no= $data->roll_no;
    $result->course_name = $data->course_name;
    $stmt = $result->read();
    $num = $stmt->rowCount();
//check if more than 0 records ....
if($num>0){
    $student_arr = array();
    $student_arr["records"] = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $student_name = $name;
        $student_course = $course_name;
        $student_item=array(
            "subject_name"=>$subject_name,
            "marks"=>$marks,
        );
        array_push($student_arr["records"],$student_item);
        
    }
    $student_arr["details"] = array(
        "name"=>$student_name,
        "course_name"=>$result->course_name
    );
    http_response_code(200);
    
    echo json_encode($student_arr);    
}
    
else{
    http_response_code(404);
    
    echo json_encode(
    array("message"=>"No Student Found."));}
}
else{
    http_response_code(503);
    
    echo json_encode(
    array("message"=>"Roll_no  is empty"));
}



?>