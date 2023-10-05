<?php
require('connection.inc.php'); 
require('function.inc.php');

$new_name = get_safe_value($con, $_POST['new_name']);
$new_name = preg_replace('/\s+/', ' ', $new_name);
$user_id = $_SESSION['USER_ID'];
$check_current_name = mysqli_num_rows(mysqli_query($con, "select * from users where name = '$new_name' and id = '$user_id'"));

if(!isset($_POST['edit_profile_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['edit_profile_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['edit_profile_form'])|| ($_POST['edit_profile_form_token'] !== $_SESSION['csrf_token']['edit_profile_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($new_name==''){
    echo "edit_profile_name_data_empty";
    die();
}
else if(validate_name($new_name)==0){
    echo "invalid_name";
    die();
}
else if($check_current_name>0){
    echo "current_name_present";
    die();
}
mysqli_query($con, "update users set name='$new_name' where id='$user_id'");
unset($_SESSION['last_generated_token_time']['edit_profile_form']);
unset($_SESSION['csrf_token']['edit_profile_form']);
session_regenerate_id(true);
echo "name_updated";
$_SESSION['Message'] = "Name has been updated successfully.";
die();
?>