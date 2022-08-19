<?php  
session_start();
include('database.inc.php');
$msg = "";

if(isset($_POST['log'])){

    $username = $_POST['user'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM user_login where Name='$username' AND Password='$password' ";
    $res = mysqli_query($con,$sql);

    if(mysqli_num_rows($res)>0)  {
    $row = mysqli_fetch_assoc($res);

    $_SESSION['IS_LOGIN'] = 'yes';
    $_SESSION['ADMIN_USER'] = $row['Name'];
  
     $namefield = $row['Name'];
     $rolefield = $row['User_Role'];
     $mobilefield = $row['Mobile'];
     $emailfield = $row['Email'];
     $addressfield = $row['Address'];
     $cityfield = $row['City'];
     $statefield = $row['State'];
     $countryfield = $row['Country'];
     $dobfield = $row['DOB'];
     $idfield = $row['ID'];

     $_SESSION['namefield'] = $namefield;
     $_SESSION['rolefield'] = $rolefield;
     $_SESSION['mobilefield'] = $mobilefield;
     $_SESSION['emailfield'] = $emailfield;
     $_SESSION['addressfield'] = $addressfield;
     $_SESSION['cityfield'] = $cityfield;
     $_SESSION['statefield'] = $statefield;
     $_SESSION['countryfield'] = $countryfield;
     $_SESSION['dobfield'] = $dobfield;
     $_SESSION['idfield'] = $idfield;

    header('Location:index1.php');    

        }
    else{
        $msg = "Invalid username or password";
    }
}
?>

<?php include('top.php');?>  
<div class="login_wbg_div">
</div>
<form method="post">    
<div class="login_main_class">
<div class="form-box">
        <label id="lbl1">Login</label> <br><br>
        <input type="text" name="user" class="input-field" placeholder="Username" required>
        <input type="text" name="pass" class="input-field" placeholder="Enter password" required> <br><br>
        <button type="submit" name="log" class ="submit-btn-login">Log-In</button>  <br>
        <span style="color:red;"><?php echo $msg; ?></span>
</div>
</div>
</form>

<?php include('footer.php');?>