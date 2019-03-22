<?php 

//including header of the read file
header("Access-Control-Allow-Origin : * ");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Credentials:true");


//include the database connecting files
include_once '../config/database.php';
include_once '../objects/students.php';

//instantiate database and product
$database = new Database();
$db = $database->getConnection();

//initialize the object
$student = new Student($db);

// we will created the read method for reading the student from the record 
// if $num>0 means record is there and we set reponse to 200 ok;
// the show the data using json file to user.

//query products
$stmt = $student->read();
$num = $stmt->rowCount();

echo $num;
//check if more than 0 records ....
if($num>0){
    $student_arr = array();
    $student_arr["records"] = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $student_item=array(
            "id"=>$id,
            "name"=>$name,
            "roll_no"=>$roll_no,
            "DOB"=>$DOB,
            "course_name"=>$course_name,
            "gender"=>$gender,
            "email"=>$email,
            
        );
        array_push($student_arr["records"],$student_item);
        
    }
    
    http_response_code(200);
    
    echo json_encode($student_arr);    
}
    
else{
    http_response_code(404);
    
    echo json_encode(
    array("message"=>"No Student Found."));}
?>