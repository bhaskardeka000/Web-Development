<?php
require('connection.inc.php'); 
require('function.inc.php');
require('paths.inc.php');
$user_id = $_SESSION['USER_ID'];
mysqli_query($con, "update notifications set status = 1 where user_id = '$user_id' and status = 0");
die();
?>