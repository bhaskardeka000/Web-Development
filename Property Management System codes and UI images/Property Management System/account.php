<?php 
session_start();
include('database.inc.php');
$msg="";
if(!isset($_SESSION['IS_LOGIN'])){
    header('Location:login.php');  
}

if(isset($_SESSION['idfield'])){
    $name =  $_SESSION['namefield'];
    $user_role =  $_SESSION['rolefield'];
    $mobile = $_SESSION['mobilefield'];
    $email = $_SESSION['emailfield'];
    $dob = $_SESSION['dobfield'];
    $address = $_SESSION['addressfield'];
    $city = $_SESSION['cityfield'];
    $state = $_SESSION['statefield'];
    $country = $_SESSION['countryfield'];
}

if(isset($_POST['submit'])){
$uname = $_POST['UName'];
$urole = $_POST['URole'];
$umobile = $_POST['UMobile'];
$uemail = $_POST['UEmail'];
$udob = $_POST['UDOB'];
$uaddress = $_POST['UAddress'];
$ucity = $_POST['UCity'];
$ustate = $_POST['UState'];
$ucountry = $_POST['UCountry'];

if($_SESSION['idfield']!=''){
    $sql = "select * from user_login where Email='$uemail' and ID!='$_SESSION[idfield]' ";
}

if(mysqli_num_rows(mysqli_query($con,$sql))>0){
    $msg="Employee already exists";
}
else{
      
        $sql = "UPDATE user_login SET Name='$uname', User_Role='$urole', Mobile='$umobile', Email='$uemail', DOB='$udob', Address='$uaddress', City='$ucity', State='$ustate', Country='$ucountry' where ID='$_SESSION[idfield]' ";
        mysqli_query($con,$sql);  
        
        $sql = "select * from user_login where ID='$_SESSION[idfield]' ";
        $query = mysqli_query($con,$sql);
        $count = mysqli_num_rows($query);

        if($count==1){
            $row = mysqli_fetch_array($query);

            $_SESSION['namefield'] = $row['Name'];
            $_SESSION['rolefield'] = $row['User_Role'];
            $_SESSION['mobilefield'] = $row['Mobile'];
            $_SESSION['emailfield'] = $row['Email'];
            $_SESSION['addressfield'] = $row['Address'];
            $_SESSION['cityfield'] = $row['City'];
            $_SESSION['statefield'] = $row['State'];
            $_SESSION['countryfield'] = $row['Country'];
            $_SESSION['dobfield'] = $row['DOB'];

            header('Location: account.php');
        }
    }
}

?>

<?php include('top1.php'); ?>
<div class="wbg5">
</div>
<div class="acc_head_class">
<h1 class="account_head">MY ACCOUNT</h1>
<hr class="account_hr">

<div class="updateclass">
<form method="post">
    <hr id="form_hr">
<input type="text" placeholder="Name" name="UName" value="<?php echo $_SESSION['namefield'] ?>" id="update_input" required> <br>
<input type="text" placeholder="User Role" name="URole" value="<?php echo $user_role ?>" id="update_input" required> <br>
<input type="number" placeholder="Mobile" name="UMobile" value="<?php echo $mobile ?>" id="update_input" required> <br>
<input type="text" placeholder="Email" name="UEmail" value="<?php echo $email ?>" id="update_input_email" required><br>
<span style="color:red;"><?php echo $msg;?></span> <br>
<input type="date" placeholder="DOB" name="UDOB" value="<?php echo $dob ?>" id="update_input" required> <br>
<input type="text" placeholder="Address" name="UAddress" value="<?php echo $address ?>" id="update_input" required> <br>
<input type="text" placeholder="City" name="UCity" value="<?php echo $city ?>" id="update_input" required> <br>
<input type="text" placeholder="State" name="UState" value="<?php echo $state ?>" id="update_input" required> <br>
<input type="text" placeholder="Country" name="UCountry" value="<?php echo $country ?>" id="update_input" required> <br>
<button type="submit" name="submit" id="account_update_submit">SUBMIT</button> <br><br>
</form>
</div>
</div>
<?php include('footer1.php');?>