<?php
require('connection.inc.php'); 
require('function.inc.php');

$type = get_safe_value($con, $_POST['type']);
$otp = get_safe_value($con, $_POST['otp']);

if(!isset($_POST['edit_profile_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['edit_profile_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['edit_profile_form']) || ($_POST['edit_profile_form_token'] !== $_SESSION['csrf_token']['edit_profile_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}

else if($type!='email' && $type!='mobile'){
	echo "invalid_type";
	die();
}

else if($otp==''){
	echo "edit_profile_verify_otp_data_empty";
	die();
}

if($type=='email'){
	if($otp==$_SESSION['NEW_EMAIL_OTP']){
        $new_email = $_SESSION['OTP_SENDING_NEW_EMAIL_ID'];
        $user_id = $_SESSION['USER_ID'];
        mysqli_query($con, "update users set email = '$new_email' where id = '$user_id'");
		unset($_SESSION['last_generated_token_time']['edit_profile_form']);
		unset($_SESSION['csrf_token']['edit_profile_form']);
		session_regenerate_id(true);
		echo "verified";
        $_SESSION['Message'] = "Email address has been updated successfully.";
		die();
	}
	else{
		echo "not_verified";
		die();
	}
}

if($type=='mobile'){
	if($otp==$_SESSION['NEW_MOBILE_OTP']){
		$new_mobile = $_SESSION['OTP_SENDING_NEW_MOBILE_NUMBER'];
		$user_id = $_SESSION['USER_ID'];
		mysqli_query($con, "update users set mobile = '$new_mobile' where id = '$user_id'");
		unset($_SESSION['last_generated_token_time']['edit_profile_form']);
		unset($_SESSION['csrf_token']['edit_profile_form']);
		session_regenerate_id(true);
		echo "verified";
		$_SESSION['Message'] = "Mobile number has been updated successfully.";
		die();
	}
	else{
		echo "not_verified";
		die();
	}
}
?>