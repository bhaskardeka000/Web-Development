<html>
<head>
<title>Admin Panel</title>
<link href="css/cpanel.css" rel="stylesheet">
</head>

<body>

<div class="navclass">
<nav class="navbar">
    <ul id="ullist">
    <li><a id="nl" href="branch.html">Nominations List</a></li>
    <li><a id="fr" href="viewfeedback.php">Feedback Report</a></li>
    <li><a id="sign1" onclick="self.close()">Sign Out</a></li>
    </ul>
    </nav>
    </div>

    <div class="result">

<div class="ad_div">
<h2 id="ad_id">CONTROL PANEL</h2>
<h3 id="ad2_id">This is an Admin Panel</h3>
</div>
<?php

$CSE = 0;
$CE = 0;
$ME = 0;
$EE = 0;
$ECE = 0;
$total = 0;

$con = mysqli_connect('127.0.0.1','root','');

if(!$con)
{
    echo "Unable to connect to the database";
}
 if(!mysqli_select_db($con,"votedata"))
 {
     echo "Database not selected";
 }




// For CSE
$sql = "SELECT * FROM vote where choice='CSE'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0){
while($row = mysqli_fetch_assoc($result)){
    if($row['choice'])
    {
        $CSE++;
    }
    $resCSE = $CSE*10;
}
    echo "
    <h3 id='branchid'>CSE: $resCSE<br></h3>
    ";

}

// For CE
$sql = "SELECT * FROM vote where choice='CE'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        if($row['choice'])
        {
            $CE++;
        }
        $resCE = $CE*10;
    }
    echo "
    <h3 id='branchid'>CE: $resCE<br></h3>
    ";
}

// For ME
$sql = "SELECT * FROM vote where choice='ME'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        if($row['choice'])
        {
            $ME++;
        }
        $resME = $ME*10;
    }
    echo "
    <h3 id='branchid'>ME: $resME<br></h3>
    ";
}


// For EE
$sql = "SELECT * FROM vote where choice='EE'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0){

    while($row = mysqli_fetch_assoc($result)){
        if($row['choice'])
        {
            $EE++;
        }
        $resEE = $EE*10;
    }
    echo "
    <h3 id='branchid'>EE: $resEE<br></h3>
    ";
}

// For ECE
$sql = "SELECT * FROM vote where choice='ECE'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0){

    while($row = mysqli_fetch_assoc($result)){
        if($row['choice'])
        {
            $ECE++;
        }
        $resECE = $ECE*10;
    }
    echo "
    <h3 id='branchid'>ECE: $resECE<br></h3>
    ";
}

//Total
$sql = "SELECT * FROM vote";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0)
{

    while($row = mysqli_fetch_assoc($result)){
        if($row['choice']){
        $total++;
        }
        $resTotal = $total*10;
    }

    echo" 
    <h3 id='branchid'>TOTAL: $resTotal</h3>
    ";



}
?>

</div>





</body>
<html>
















