<?php 
require('connection.inc.php'); 
require('function.inc.php'); 
$name = get_safe_value($con, $_POST['name']);
$mobile = get_safe_value($con, $_POST['mobile']);
$email = get_safe_value($con, $_POST['email']);
$message = get_safe_value($con, $_POST['message']);
$added_on = date('Y-m-d h:i:s');

$name = preg_replace('/\s+/', ' ', $name);
$message = preg_replace('/\s+/', ' ', $message);

if(!isset($_POST['contact_us_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['contact_us_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['contact_us_form']) || ($_POST['contact_us_form_token'] !== $_SESSION['csrf_token']['contact_us_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($name=='' || $mobile=='' || $email=='' || $message==''){
    echo "send_message_data_empty";
    die();
}
else if(validate_name($name)==0){
    echo "invalid_name";
    die();
}
else if(validate_mobile_number($mobile)==0){
    echo "invalid_mobile_number";
    die();
}
else if(validate_email_address($email)==0){
    echo "invalid_email_address";
    die();
}
else if(strlen($message)<=5){
    echo "message_length_insufficient";
    die();
}
mysqli_query($con, "insert into contact_us(name, mobile, email, message, added_on) values('$name', '$mobile', '$email', '$message', '$added_on')");
unset($_SESSION['last_generated_token_time']['contact_us_form']);
unset($_SESSION['csrf_token']['contact_us_form']);
session_regenerate_id(true);
echo "sent";
die();
?>