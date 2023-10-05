<?php
require('connection.inc.php'); 
require('function.inc.php');

$type = get_safe_value($con, $_POST['type']);

if(!isset($_POST['edit_profile_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['edit_profile_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['edit_profile_form']) || ($_POST['edit_profile_form_token'] !== $_SESSION['csrf_token']['edit_profile_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}

else if($type!='email' && $type!='mobile'){
	echo "invalid_type";
	die();
}

if($type=='email'){
    $new_email = get_safe_value($con, $_POST['new_email']);
    $user_id = $_SESSION['USER_ID'];
    $check_current_email = mysqli_num_rows(mysqli_query($con, "select * from users where email = '$new_email' and id = '$user_id'"));
	$check_email = mysqli_num_rows(mysqli_query($con, "select * from users where email = '$new_email'"));
    if($new_email==''){
		echo "edit_profile_send_otp_email_data_empty";
        die();
	}
	else if(validate_email_address($new_email)==0){
		echo "invalid_email_address";
		die();
	}
	else if($check_current_email>0){
        echo "current_email_present";
        die();
    }
	else if($check_email>0){
		echo "email_present";
		die();
	}
	$_SESSION['OTP_SENDING_NEW_EMAIL_ID'] = $new_email;
    $otp = rand(111111, 999999);
    $_SESSION['NEW_EMAIL_OTP'] = $otp;
    $html = "Scotch Club International: Dear user, $otp is your OTP.";

    include('smtp/PHPMailerAutoload.php');
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="grostuff24@gmail.com";
	$mail->Password="koonzxdlyxabqqap";
	$mail->SetFrom("grostuff24@gmail.com");
	$mail->addAddress($new_email);
	$mail->IsHTML(true);
	$mail->Subject="Scotch Club International - New OTP";
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	try{
	if($mail->send()){
		// unset($_SESSION['csrf_token']);
		echo "done";
		die();
	}
	}
	catch(Exception){
		//echo "Error occur";
		die();
	}
}

if($type=='mobile'){
    $new_mobile = get_safe_value($con, $_POST['new_mobile']);
	$user_id = $_SESSION['USER_ID'];
    $check_current_mobile = mysqli_num_rows(mysqli_query($con, "select * from users where mobile = '$new_mobile' and id = '$user_id'"));
	$check_mobile = mysqli_num_rows(mysqli_query($con, "select * from users where mobile = '$new_mobile'"));
	if($new_mobile==''){
		echo "edit_profile_send_otp_mobile_data_empty";
        die();
	}
	else if(validate_mobile_number($new_mobile)==0){
		echo "invalid_mobile_number";
		die();
	}
	else if($check_current_mobile>0){
        echo "current_mobile_present";
        die();
    }
	else if($check_mobile>0){
		echo "mobile_present";
		die();
	}
	$_SESSION['OTP_SENDING_NEW_MOBILE_NUMBER'] = $new_mobile;
    $otp = rand(111111, 999999);
    $_SESSION['NEW_MOBILE_OTP'] = $otp;
    $message = "Scotch Club International: Dear user, $otp is your OTP.";

	$fields = array(
		"message" => $message,
		"language" => "english",
		"route" => "v3",
		"numbers" => $new_mobile,
	);
	
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_SSL_VERIFYHOST => 0,
	  CURLOPT_SSL_VERIFYPEER => 0,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($fields),
	  CURLOPT_HTTPHEADER => array(
		"authorization: kSRN9tYfsxKaTn5qPW6I3mh2ouAOQL4l7Mb18z0igVJBwGvXUETaoPmreCI8kyfRZWAhq6s3H0l17VxG",
		"accept: */*",
		"cache-control: no-cache",
		"content-type: application/json"
	  ),
	));
	
	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if($err){
	//   echo "cURL Error #:" . $err;
	die();
	}
	else{
		// unset($_SESSION['csrf_token']);
		echo "done";
		die();
	}

}
?>