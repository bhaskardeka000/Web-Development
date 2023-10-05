<?php
require('connection.inc.php'); 
require('function.inc.php');
require('paths.inc.php');
$post_name = get_safe_value($con, $_POST['post_name']);
$name = get_safe_value($con, $_POST['name']);
$email = get_safe_value($con, $_POST['email']);
$mobile = get_safe_value($con, $_POST['mobile']);
$address = get_safe_value($con, $_POST['address']);
$pincode = get_safe_value($con, $_POST['pincode']);
$state = get_safe_value($con, $_POST['state']);
$gender = get_safe_value($con, $_POST['gender']);

$filename = $_FILES['resume']['name'];
$filetype = $_FILES['resume']['type'];
$fileerror = $_FILES['resume']['error'];
$filepath = $_FILES['resume']['tmp_name'];
$filesize = $_FILES['resume']['size'];

$file_ext = explode('.', $filename);
$file_ext_check = strtolower(end($file_ext));
$valid_file_ext = array('pdf', 'docx');
$size = $filesize/1024;

$post_name = preg_replace('/\s+/', ' ', $post_name);
$name = preg_replace('/\s+/', ' ', $name);

$state = strtoupper($state);
$check_pincode_result = mysqli_query($con, "select StateName from pincodes where pincode='$pincode' limit 1");
$state_name = mysqli_fetch_assoc($check_pincode_result);

if(!isset($_POST['career_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['career_form'])|| !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['career_form']) || ($_POST['career_form_token'] !== $_SESSION['csrf_token']['career_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($post_name=='' ||$name=='' || $email=='' || $mobile=='' || $address=='' || $pincode=='' || $state=='' || $gender=='' || $filename=='' || $filetype=='' || $fileerror=='' || $filepath=='' || $filesize==''){
    echo "career_application_data_empty";
    die();
}
else if(validate_name($post_name)==0){
    echo "invalid_post_name";
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
else if(strlen($address)<=5){
    echo "address_length_insufficient";
    die();
}
else if(mysqli_num_rows($check_pincode_result)<1){
    echo "invalid_pincode";
    die();
}
else if(mysqli_num_rows($check_pincode_result)>0 && trim($state_name['StateName'])!=$state){
    echo "invalid_state_name";
    die();
}
else if($gender!='Male' && $gender!='Female' && $gender!='Others'){
    echo "invalid_gender_error";
    die();
}
if($fileerror==0){
    if(in_array($file_ext_check, $valid_file_ext)){
        if($size<8000){
            $unique_id = uniqid(mt_rand(), true);
            $unique_id = str_replace(".", "", $unique_id);
            $resume = $unique_id.'.'.$file_ext_check;
            move_uploaded_file($filepath, CAREER_FILES_SERVER_PATH.$resume);
            $added_on = date('Y-m-d h:i:s');
            mysqli_query($con, "insert into careers(post_name, name, email, mobile, address, pincode, state, gender, resume, added_on) values('$post_name', '$name', '$email', '$mobile', '$address', '$pincode', '$state', '$gender', '$resume', '$added_on')");
            unset($_SESSION['last_generated_token_time']['career_form']);
            unset($_SESSION['csrf_token']['career_form']);
            session_regenerate_id(true);
            echo "submitted";
            die();
        }
        else{
            echo "resume_size_error";
            die();
        }

    }
    else{
        echo "resume_type_error";
        die();
    }

}
?>