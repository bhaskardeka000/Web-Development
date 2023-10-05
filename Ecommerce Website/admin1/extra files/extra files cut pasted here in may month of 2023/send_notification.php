<?php
require('connection.inc.php'); 
require('function.inc.php');
require('paths.inc.php');
$user_select = get_safe_value($con, $_POST['user_select']);
$enter_user_id = get_safe_value($con, $_POST['enter_user_id']);
$subject = get_safe_value($con, $_POST['subject']);
$message = get_safe_value($con, $_POST['message']);
$status = 0;
$added_on = date('Y-m-d h:i:s');
$notification_common_id = rand(11111, 99999);

if($user_select=='All Users' && $enter_user_id==''){
    $res = mysqli_query($con, "select id from users");
    while($row = mysqli_fetch_assoc($res)){
        $user_id = $row['id'];
        $user = "All";
        mysqli_query($con, "insert into notifications(notification_common_id, user, user_id, subject, message, status, added_on) values('$notification_common_id', '$user', '$user_id', '$subject', '$message', '$status', '$added_on')");
    }
    echo "submitted";
}

else if($user_select=='One User' && $enter_user_id!=''){
    $res = mysqli_query($con, "select id, name from users where id = '$enter_user_id'");
    $user_id_check = mysqli_num_rows($res);
    if($user_id_check>0){
        while($row = mysqli_fetch_assoc($res)){
            $user_id = $row['id'];
            $user = $row['name'];
            mysqli_query($con, "insert into notifications(notification_common_id, user, user_id, subject, message, status, added_on) values('$notification_common_id', '$user', '$user_id', '$subject', '$message', '$status', '$added_on')");
        }
        echo "submitted";
    }
    else{
        echo "not_found";
    }
}
?>