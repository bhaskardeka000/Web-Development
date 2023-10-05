<?php
session_set_cookie_params(['SameSite' => 'None', 'Secure' => true]);
session_name("adm_sid");
session_start();
$con = mysqli_connect('localhost','root','','ecommerce_database');
?>