<?php
$current_string = $_SERVER['REQUEST_URI'];
$current_array = explode('/',$current_string);           //explode is used to convert a string to array.
$current_path = $current_array[count($current_array)-1];

$title='';
if($current_path=='' || $current_path=='index1.php'){
    $title='Dashboard';
}
if($current_path=='account.php'){
    $title='My Account';
}
if($current_path=='manage_property2.php'){
    $title='Manage Property';
}
if($current_path=='new_property.php'){
    $title='Add/Edit Property';
}
if($current_path=='change_password.php'){
    $title='Reset Password';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title?> </title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
<div class=overall_main_div_1>
<div class="maindiv">
        <a href="#" class="logo">PROPERTY WEBSITE</a>
        <ul class="nav">
        <li><a href="index1.php" id="aclass">ADMIN HOME</a></li>
        <li><a href="account.php" id="aclass">MY ACCOUNT</a></li>
        <li><a href="manage_property2.php" id="aclass">MANAGE PROPERTY</a></li>
        <li><a href="change_password.php" id="aclass">RESET PASSWORD</a></li>
        <li><a href="logout.php" id="aclass">LOGOUT</a></li>
    </ul>
    </div>