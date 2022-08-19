<?php 
$current_string = $_SERVER['REQUEST_URI'];
$current_array = explode('/',$current_string);           //explode is used to convert a string to array.
$current_path = $current_array[count($current_array)-1];

$title='';
if($current_path=='' || $current_path=='index.php'){
    $title='Property Website-Home';
}
if($current_path=='prop3.php'){
    $title='All Property';
}
if($current_path=='login.php'){
    $title='Admin Login';
}
if($current_path=='contact.php'){
    $title='Contact Us';
}
if($current_path=='about.php'){
    $title='About Us';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $title ?> </title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
<div class=overall_main_div>
<div class="maindiv">
        <a href="index.php" class="logo">PROPERTY WEBSITE</a>
        <ul class="nav">
        <li><a href="index.php">HOME</a></li>
        <li><a href="prop3.php">ALL PROPERTY</a></li>
        <li><a href="login.php">LOGIN</a></li>
        <li><a href="contact.php">CONTACT US</a></li>
        <li><a href="about.php">ABOUT US</a></li>
    </ul>
    </div>