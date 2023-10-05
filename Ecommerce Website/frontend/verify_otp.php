<?php
require('connection.inc.php'); 
require('function.inc.php');


$type = get_safe_value($con, $_POST['type']);
$otp = get_safe_value($con, $_POST['otp']);

if(!isset($_POST['email_and_mobile_verification_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['email_and_mobile_verification_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['email_and_mobile_verification_form']) || ($_POST['email_and_mobile_verification_form_token'] !== $_SESSION['csrf_token']['email_and_mobile_verification_form'])){
	echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}

else if($type!='email' && $type!='mobile'){
	echo "invalid_type";
	die();
}

else if($otp==''){
	echo "verify_otp_data_empty";
	die();
}

if($type=='email'){
	if($otp==$_SESSION['EMAIL_OTP']){
		// unset($_SESSION['csrf_token_for_email_and_mobile_registration']);
		session_regenerate_id(true);
		echo "verified";
		die();
	}
	else{
		echo "not_verified";
		die();
	}
}

if($type=='mobile'){
	if($otp==$_SESSION['MOBILE_OTP']){
		// unset($_SESSION['csrf_token_for_email_and_mobile_registration']);
		session_regenerate_id(true);
		echo "verified";
		die();
	}
	else{
		echo "not_verified";
		die();
	}
}
?>