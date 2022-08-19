
<link href="css/votesubmit.css" rel="stylesheet">




<?php

$name = $_POST['name'];
$roll = $_POST['rollno'];
$vote = $_POST['vote'];

$con = mysqli_connect('127.0.0.1','root','');

if(!$con)
{
    echo "Unable to connect to the database";
}
 if(!mysqli_select_db($con,"votedata"))
 {
     echo "Database not selected";
 }

$sql = "INSERT INTO vote(Name,roll,choice) VALUES('$name','$roll','$vote')" ;


if(mysqli_query($con,$sql))
{
    echo' <div class="subvote">
    <p id="votetext1">You have successfully submitted your vote. Thank You!!!</p>
    <p id="votetext2">Note: Voting results will be announced within one month.</p>
    </div> 
    <hr>';
}

else
{
    echo "Error! Please try again later";
}

header('Refresh: 2; URL=index.html');
?>


