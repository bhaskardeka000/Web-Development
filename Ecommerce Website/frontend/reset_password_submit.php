<?php
require('connection.inc.php'); 
require('function.inc.php');

$new_password = get_safe_value($con, $_POST['new_password']);
$confirm_password = get_safe_value($con, $_POST['confirm_password']);
$token = get_safe_value($con, $_POST['token']);
// $new_password_encrypt = password_hash($new_password, PASSWORD_BCRYPT);
// $confirm_password_encrypt = password_hash($confirm_password, PASSWORD_BCRYPT);

$res = mysqli_query($con, "select * from users where reset_token='$token'");
$check_token = mysqli_num_rows($res);
$fetched_user = mysqli_fetch_assoc($res);

if(!isset($_POST['reset_password_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['reset_password_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['reset_password_form']) || ($_POST['reset_password_form_token'] !== $_SESSION['csrf_token']['reset_password_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($new_password=='' || $confirm_password==''){
	echo "change_password_submit_data_empty";
	die();
}
else if(validate_password($new_password)==0){
	echo "invalid_password_pattern";
	die();
}
else if($new_password!=$confirm_password){
	echo "new_password_and_confirm_password_not_matching";
	die();
}
else if($check_token<1 || (time() - $fetched_user['reset_token_expires_at'] >= 60 * 20)){
	mysqli_query($con, "update users set reset_token = null, reset_token_expires_at = null where reset_token = '$token'");
	echo "invalid_token_or_token_expired";
	die();
}
// when($new_password == $confirm_password)
// $new_token = bin2hex(random_bytes(16));
$new_password = password_hash($new_password, PASSWORD_DEFAULT, ['cost' => 12]);
mysqli_query($con, "update users set password='$new_password', reset_token = null, reset_token_expires_at = null where reset_token='$token'");
unset($_SESSION['last_generated_token_time']['reset_password_form']);
unset($_SESSION['csrf_token']['reset_password_form']);
session_regenerate_id(true);
echo "matching";
die();
?>