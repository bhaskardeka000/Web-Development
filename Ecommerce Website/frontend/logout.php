<?php 
require('connection.inc.php');
if(!isset($_POST['logout_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['logout_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['logout_form']) || $_POST['logout_form_token'] !== $_SESSION['csrf_token']['logout_form']){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_NAME']);
unset($_SESSION['last_generated_token_time']['logout_form']);
unset($_SESSION['csrf_token']['logout_form']);
session_regenerate_id(true);
echo "logged_out";
die();
?>