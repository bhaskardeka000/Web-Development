
<link href="css/login.css" rel="stylesheet">






<?php
$con = mysqli_connect('127.0.0.1','root','');

if(!$con){
    echo "Unable to connect to the database";
}
if(!mysqli_select_db($con,"votedata"))
{
    echo "Database is not selected";
}

$roll = $_POST['roll'];
$password = $_POST['pass'];

$sql = "SELECT * FROM admin WHERE RollNo='$roll' and Password='$password'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$count = mysqli_num_rows($query);

if($count==1)
{
   
    header("location:cpanel.php");
}
else
{

    echo'<div class="logintext">
        <p id="logid">Error: Roll no or password is incorrect!!!</p>
        </div>';
}








?>