
<link href="css/registeradmin.css" rel="stylesheet">

<?php

$con = mysqli_connect('127.0.0.1','root','');

if(!$con){
    echo "Unable to connect to the database";
}
if(!mysqli_select_db($con,"votedata"))
{
    echo "Database is not selected";
}

$Name = $_POST['name'];
$Roll = $_POST['rollno'];
$Pass = $_POST['password'];
$date = $_POST['date'];
$phone= $_POST['phone'];
$age = $_POST['age'];

$sql = "INSERT INTO admin(Name,RollNo,Date,Phone,Age,Password) VALUES('$Name','$Roll','$date','$phone','$age','$Pass')";
$query = mysqli_query($con,$sql);

if(!$query)
{
    echo "Error: Please try again";
}
else
{
    echo' <div class="content">
     <p id="l1">You have successfully registered.Thank You!!!</p>
    <p id="l2">You are now an admin of the online voting system.</p>
    <p id="l3">Go back to<a href="admin_login1.html">Login page</a></p>
   </div> ';
}
