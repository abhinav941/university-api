<?php 

header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");

include_once '../config/database.php';.o
include_once '../objects/students.php';

$database = new Database();
$connect = $database->getConnection();

$student = new Student($connect);

$keyword=isset($_GET['s']) ? $_GET['s'] : "";
$stmt = $student->search($keyword);
$num = $stmt->rowCount();

if($num>0){
    $student_arr=array();
    $student_arr['records']=array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $student_item=array(
            "id"=>$id,
            "name"=>$name,
            "roll_no"=>$roll_no,
            "DOB"=>$DOB,
            "course_name"=>$course_name,
            "gender"=>$gender,
            "email"=>$email
        );
        array_push($student_arr['records'],$student_item);
    }
    http_response_code(200);
    
    echo json_encode($student_arr);
}
else{
    http_response_code(404);
    
    echo json_encode(array("message"=>"No such student exist"));
}