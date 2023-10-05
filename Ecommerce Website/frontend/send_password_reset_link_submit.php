<?php
require('connection.inc.php'); 
require('function.inc.php');
require('paths.inc.php');
$email = get_safe_value($con, $_POST['email']);

$res = mysqli_query($con, "select * from users where email='$email'");
$check_user = mysqli_num_rows($res);

if(!isset($_POST['send_password_reset_link_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['send_password_reset_link_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['send_password_reset_link_form']) || ($_POST['send_password_reset_link_form_token'] !== $_SESSION['csrf_token']['send_password_reset_link_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($email==''){
	echo "password_reset_link_data_empty";
	die();
}
else if(validate_email_address($email)==0){
	echo "invalid_email_address";
	die();
}
else if($check_user<1){
	echo "password_reset_not_mailed";
	die();
}
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    // $token = $row['token'];
	$token = bin2hex(random_bytes(16));
	$reset_token = hash("sha256", $token);
	$reset_token_expires_at = time();
	mysqli_query($con, "update users set reset_token = '$reset_token', reset_token_expires_at = '$reset_token_expires_at' where email = '$email'");


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
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject="Scotch Club International - Password Reset";
	$mail->Body= "Scotch Club International: Hi, $name. Click <a href=".PASSWORD_RESET_LINK_SITE_PATH."reset_password.php?token=$reset_token>here</a> to reset your password. <br> Date: ".date('d/m/Y').", Time: ".date('H:i:s').".";
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	try{
	if($mail->send()){
		unset($_SESSION['last_generated_token_time']['send_password_reset_link_form']);
		unset($_SESSION['csrf_token']['send_password_reset_link_form']);
		session_regenerate_id(true);
		echo "password_reset_mailed";
		die();
	}
	}
	catch(Exception){
		//echo "Error occur";
		die();
	}
?>