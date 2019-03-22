<?php 

//including header of the read file
header("Access-Control-Allow-Origin : * ");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Credentials:true");


//include the database connecting files
include_once '../config/database.php';
include_once '../objects/admin.php';

//instantiate database and product
$database = new Database();
$db = $database->getConnection();

//initialize the object
$admin = new Admin($db);

// we will created the read method for reading the student from the record 
// if $num>0 means record is there and we set reponse to 200 ok;
// the show the data using json file to user.

//query products

$data = json_decode(file_get_contents("php://input"));
$admin->username = $data->username;
$admin->password = $data->password;

$stmt = $admin->read();
$num = $stmt->rowCount();
echo $num;
//check if more than 0 records ....
if($num>0){
    $student_arr = array(
    "message"=>"Successfully signed in",
    "authentication"=>"true");
    
    http_response_code(200);
    
    echo json_encode($student_arr);    
}
    
else{
    http_response_code(404);
    
    echo json_encode(
    array("message"=>"Sorry wrong username and password","authenication"=>"false"));
}
?>