<?php 

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
header("Acces-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

//get database connection and get product object
include_once '../config/database.php';
include_once '../objects/courses.php';
include_once "../objects/subject.php";
//instantiate database
$database =  new Database();
$connect = $database->getConnection();

//initiate student
$courses =  new Courses($connect);
$subject = new Subject($connect);
//get posted data 
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->course_name) && !empty($data->subjects)){
    
    $arr =array();
    $arr["message"] = array();
    $courses->name = $data->course_name;
    if($courses->create()){
          array_push($arr["message"],array("course_message"=>"Course is successfully Added","type"=>"success"));
    }
    else{
        http_response_code(503);
        
        array_push($arr["message"] , array("course_message"=>"Course is not Added","type"=>"danger"));
    }
    
    $stmt = $courses->extractId();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $subject->course_id = $row['id'];
    
    $subjects = $data->subjects;
    $check =0;
    
    for($i=0;$i<count($subjects);$i++){
        $subject->name = $subjects[$i];
        if($subject->add()){
            $check = 1;    
        }
        else{
            http_response_code(503);
        array_push($arr["message"] , array("subject_message"=>"subject is not Added","type"=>"danger"));
           
            break;
        }
    }
    if($check==1){
        http_response_code(200);
        array_push($arr["message"] , array("subject_message"=>"subject is successfully Added","type"=>"success"));    
    }
    
    echo json_encode($arr);
    
}
else{
    http_response_code(400);
    
    echo json_encode(array("message"=>"data was incomplete","type"=>"danger"));
}
?>