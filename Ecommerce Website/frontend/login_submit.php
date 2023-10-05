<?php 
require('connection.inc.php');
require('function.inc.php');
$email = get_safe_value($con, $_POST['email']);
$password = get_safe_value($con, $_POST['password']);

$res = mysqli_query($con, "select * from users where email='$email'");
$check_user = mysqli_num_rows($res);
$row = mysqli_fetch_assoc($res);

if(!isset($_POST['login_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['login_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['login_form']) || $_POST['login_form_token'] !== $_SESSION['csrf_token']['login_form']){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($email=='' || $password==''){
    echo "login_submit_data_empty";
    die();
}
else if($check_user<1){
    echo "wrong_email";
    die();
}
else if(!password_verify($password, $row['password'])){
    echo "wrong_password";
    die();
}
    $_SESSION['USER_LOGIN'] = 'yes';
    $_SESSION['USER_ID'] = $row['id'];
    $_SESSION['USER_NAME'] = $row['name'];
    unset($_SESSION['last_generated_token_time']['login_form']);
    unset($_SESSION['csrf_token']['login_form']);
    session_regenerate_id(true);
    echo "valid";
    die();
?>