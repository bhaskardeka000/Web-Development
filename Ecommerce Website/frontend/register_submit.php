<?php 
require('connection.inc.php'); 
require('function.inc.php'); 
$name = get_safe_value($con, $_POST['name']);
$email = get_safe_value($con, $_POST['email']);
$mobile = get_safe_value($con, $_POST['mobile']);
$password = get_safe_value($con, $_POST['password']);

$name = preg_replace('/\s+/', ' ', $name);

$check_email = mysqli_num_rows(mysqli_query($con, "select * from users where email = '$email'"));
$check_mobile = mysqli_num_rows(mysqli_query($con, "select * from users where mobile = '$mobile'"));

if(!isset($_POST['registration_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['registration_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['registration_form']) || ($_POST['registration_form_token'] !== $_SESSION['csrf_token']['registration_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($name=='' || $email=='' || $mobile=='' || $password==''){
    echo "register_submit_data_empty";
    die();
}
else if(validate_name($name)==0){
    echo "invalid_name";
    die();
}
else if(validate_email_address($email)==0){
    echo "invalid_email_address";
    die();
}
else if(validate_mobile_number($mobile)==0){
    echo "invalid_mobile_number";
    die();
}
else if(validate_password($password)==0){
    echo "invalid_password_pattern";
    die();
}
else if($check_email>0){
    echo "email_present";
    die();
}
else if($check_mobile>0){
    echo "mobile_present";
    die();
}
else if(($email != $_SESSION['OTP_SENDING_EMAIL_ID'] || $mobile != $_SESSION['OTP_SENDING_MOBILE_NUMBER']) || ($email != $_SESSION['OTP_SENDING_EMAIL_ID'] && $mobile != $_SESSION['OTP_SENDING_MOBILE_NUMBER'])){
    echo "email_address_or_mobile_number_change_not_allowed";
    die();
}
// $token = bin2hex(random_bytes(16));
$password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
$added_on = date('Y-m-d h:i:s');
mysqli_query($con, "insert into users(name, email, mobile, password, added_on) values('$name', '$email', '$mobile', '$password', '$added_on')");
unset($_SESSION['last_generated_token_time']['email_and_mobile_verification_form']);
unset($_SESSION['csrf_token']['email_and_mobile_verification_form']);
unset($_SESSION['last_generated_token_time']['registration_form']);
unset($_SESSION['csrf_token']['registration_form']);
session_regenerate_id(true);
echo "insert";
die();
?>