<link href="css/feedback.css" rel="stylesheet">
  
<?php

$namefield = $_POST['fname'];
$mailfield = $_POST['fmail'];
$feedfield = $_POST['ffeed'];

$con = mysqli_connect('127.0.0.1','root','');

if(!$con)
{
    echo"Unable to connect to the database";
}
 if(!mysqli_select_db($con,"votedata"))
 {
     echo "Error selecting the database";
 }

$sql = "INSERT INTO feedback(Name,Email,Feedback) VALUES('$namefield','$mailfield','$feedfield')";

$result = mysqli_query($con,$sql);

if(!$result)
{

    echo "Error! Please try again later";
}
else
{

    echo '<div class="message">
       <p id="messageid"> Thank you for your feedback!!! </p>
    </div>
    <hr> ';
}

header('Refresh: 2; URL=index.html');

?>
