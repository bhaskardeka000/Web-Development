<?php
require('connection.inc.php'); 
require('function.inc.php');


$current_password = get_safe_value($con, $_POST['current_password']);
$new_password = get_safe_value($con, $_POST['new_password']);
$confirm_password = get_safe_value($con, $_POST['confirm_password']);
$user_id = $_SESSION['USER_ID'];

$row = mysqli_fetch_assoc(mysqli_query($con, "select password from users where id='$user_id'"));

if(!isset($_POST['edit_profile_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['edit_profile_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['edit_profile_form']) || ($_POST['edit_profile_form_token'] !== $_SESSION['csrf_token']['edit_profile_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($current_password=='' || $new_password=='' || $confirm_password==''){
    echo "update_password_date_empty";
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
// else if($row['password']!=$current_password){
else if(!password_verify($current_password, $row['password'])){
    echo "invalid_current_password";
    die();
}
    $new_password = password_hash($new_password, PASSWORD_DEFAULT, ['cost' => 12]);
    mysqli_query($con, "update users set password='$new_password' where id='$user_id'");
    unset($_SESSION['last_generated_token_time']['edit_profile_form']);
    unset($_SESSION['csrf_token']['edit_profile_form']);
    session_regenerate_id(true);
    echo "password_updated";
    $_SESSION['Message'] = "Password has been changed successfully.";
    die();
?>