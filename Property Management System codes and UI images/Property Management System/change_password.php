<?php
session_start();
include('database.inc.php');
if(!isset($_SESSION['IS_LOGIN'])){
    header('Location:login.php');  
}
$msg="";
$msg1="";
$sql = "SELECT Password from user_login where ID='$_SESSION[idfield]' ";
$query = mysqli_query($con,$sql);
if(mysqli_num_rows($query)>0)
{
$row = mysqli_fetch_assoc($query);
$oldpass = $row['Password'];
}

if(isset($_POST['check'])){
$password1 = $_POST['pass1'];
$password2 = $_POST['pass2'];
if($oldpass== $password1){
    $sql = "UPDATE user_login SET Password='$password2' where ID='$_SESSION[idfield]' ";
    mysqli_query($con,$sql);
    $msg1 = "Password changed successfully";
}
else{
    $msg = "Old Password is incorrect";
}
}
?>

<?php include('top1.php');?>
<div class="change_pwd_wbg">
</div>

<div class="reset_pwd_div">
        <form method="post" class="main-form-reset">
            <h2 style="font-family: 'Poppins', sans-serif;font-size: 32px;">Reset Password</h2>
            <input type="text" name="pass1" placeholder="Old Password" class="input_reset_password" required>
            <span style="color:red; padding: 0px 155px 0px 0px;"><?php echo $msg;?></span>
            <input type="text" name="pass2" placeholder="New Password" class="input_reset_password" required><br>
            <input type="submit" name="check" value="Change Password" class="reset_password_btn">
            <span style="color:#259e2a; padding-top:6px;"><?php echo $msg1;?></span>
        </form>
    </div>
<?php include('footer1.php');?>