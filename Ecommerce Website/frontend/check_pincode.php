<?php
require('connection.inc.php'); 
require('function.inc.php');
$pincode = get_safe_value($con, $_POST['pincode']);
$res = mysqli_query($con, "select StateName from pincodes where pincode='$pincode' limit 1");
if(mysqli_num_rows($res)>0){
    $state_name = mysqli_fetch_assoc($res);
    echo $state_name['StateName'];
    die();
}
else{
    echo "no_pincode_data_found";
    die();
}
?>