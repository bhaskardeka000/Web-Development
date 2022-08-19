<html>
<head><title>Feedback Report</title>
<link href="css/viewfeedback.css" rel="stylesheet">
</head>
<body>








<?php

$con = mysqli_connect('127.0.0.1','root','');

if(!$con)
{
    echo "Unable to connect to the database";
}
 if(!mysqli_select_db($con,"votedata"))
 {
     echo "Error! Database is not selected";
 }

$query = "SELECT * FROM feedback";
$result = mysqli_query($con,$query);

echo "<div id='head'>";
echo "<h2>Feedback Report</h2>";
if(mysqli_num_rows($result)>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        echo "<div id='go'>";
        echo "Name: "; echo $row['Name']; echo "<br><br>";
        echo "Email: ";echo $row['Email']; echo "<br><br>";
        echo "Feedback: ";echo $row['Feedback'];
        
  echo "</div>";
    }

}
echo "</div>";
    ?>
  
    


</body>
</html>