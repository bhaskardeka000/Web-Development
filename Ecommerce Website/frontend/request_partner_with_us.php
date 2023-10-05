<?php
require('connection.inc.php'); 
require('function.inc.php');
require('paths.inc.php');
$name = get_safe_value($con, $_POST['name']);
$email = get_safe_value($con, $_POST['email']);
$mobile = get_safe_value($con, $_POST['mobile']);
$address = get_safe_value($con, $_POST['address']);
$pincode = get_safe_value($con, $_POST['pincode']);
$state = get_safe_value($con, $_POST['state']);
$gst_pan_card = get_safe_value($con, $_POST['gst_pan_card']);
$gst_pan_card_number = get_safe_value($con, $_POST['gst_pan_card_number']);
$license = get_safe_value($con, $_POST['license']);
$license_number = get_safe_value($con, $_POST['license_number']);
$applied_for = get_safe_value($con, $_POST['applied_for']);
$referred_by = get_safe_value($con, $_POST['referred_by']);
$business_start_date = get_safe_value($con, $_POST['business_start_date']);
$declared = get_safe_value($con, $_POST['declared']);
$added_on = date('Y-m-d h:i:s');

$name = preg_replace('/\s+/', ' ', $name);
$address = preg_replace('/\s+/', ' ', $address);
$referred_by = preg_replace('/\s+/', ' ', $referred_by);
$state = strtoupper($state);
$check_pincode_result = mysqli_query($con, "select StateName from pincodes where pincode='$pincode' limit 1");
$state_name = mysqli_fetch_assoc($check_pincode_result);

if(!isset($_POST['partner_with_us_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['partner_with_us_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['partner_with_us_form']) || ($_POST['partner_with_us_form_token'] !== $_SESSION['csrf_token']['partner_with_us_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if($name=='' || $email=='' || $mobile=='' || $address=='' || $pincode=='' || $state=='' || $gst_pan_card=='' || $gst_pan_card_number=='' || $license=='' || $license_number=='' || $applied_for=='' || $referred_by=='' || $business_start_date=='' || $declared==''){
    echo "partner_with_us_data_empty";
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
else if($gst_pan_card!='GST' && $gst_pan_card!='Pan Card'){
    echo "invalid_gst_pan_card_error";
    die();
}
else if($license!='FSSAI License' && $license!='Trade License' && $license!='Other License'){
    echo "invalid_license_error";
    die();
}
else if($applied_for!='Super Stockist' && $applied_for!='Distributor' && $applied_for!='Wholesaler' && $applied_for!='Retailer'){
    echo "invalid_applied_for_error";
    die();
}
else if(validate_name($referred_by)==0){
    echo "invalid_referred_by_name";
    die();
}
else if(validate_date($business_start_date)==0){
    echo "invalid_date";
    die();
}
else if($declared!='declared'){
    echo "declared_value_cannot_be_changed";
    die();
}
$declared = "I hereby declare that information provided above is true and correct in every respect and in case any information is found incorrect even partially the partnership request shall be liable to be rejected.";
mysqli_query($con, "insert into partners(name, email, mobile, address, pincode, state, gst_pan_card, gst_pan_card_number, license, license_number, applied_for, referred_by, business_start_date, declared, added_on) values('$name', '$email', '$mobile', '$address', '$pincode', '$state', '$gst_pan_card', '$gst_pan_card_number', '$license', '$license_number', '$applied_for', '$referred_by', '$business_start_date', '$declared', '$added_on')");
unset($_SESSION['last_generated_token_time']['partner_with_us_form']);
unset($_SESSION['csrf_token']['partner_with_us_form']);
session_regenerate_id(true);
echo "submitted";
die();
?>