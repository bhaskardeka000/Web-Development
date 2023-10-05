<?php
require('connection.inc.php');
require('function.inc.php');

if(isset($_POST['submit'])){
    if(!isset($_POST['login_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['login_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['login_form']) || ($_POST['login_form_token'] !== $_SESSION['csrf_token']['login_form'])){
        ?>
        <script>
        alert("Error occured: Multiple tabs are open/token expired/invalid token.");
        window.location.href = "login.php";
        </script>
        <?php
        die();
     }

 $username = get_safe_value($con, $_POST['username']);
 $password = get_safe_value($con, $_POST['password']);

 $res = mysqli_query($con, "select * from admins where username='$username' and password='$password'");
 $check_admin = mysqli_num_rows($res);

if($username=='' || $password==''){
    // $msg_error = '2';
    $_SESSION['Message_error'] = 'Please enter username and password.';
    // unset($_SESSION['csrf_token_for_login']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
}
else if($check_admin<1){
    // $msg_error = '1';
    $_SESSION['Message_error'] = 'Please enter valid login details.';
    // unset($_SESSION['csrf_token_for_login']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
}

$row = mysqli_fetch_assoc($res);
$_SESSION['ADMIN_LOGIN'] = 'yes';
$_SESSION['ADMIN_ID'] = $row['id'];
$_SESSION['ADMIN_NAME'] = $row['admin_name'];
unset($_SESSION['last_generated_token_time']['login_form']);
unset($_SESSION['csrf_token']['login_form']);
session_regenerate_id(true);
header('location: index.php');
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['login_form'])){
    $login_form_generated_token = bin2hex(random_bytes(16));
    $_SESSION['csrf_token']['login_form'] = $login_form_generated_token;
    $_SESSION['last_generated_token_time']['login_form'] = time();
  }
  else{
    $interval = 60 * 25;
    if(time() -  $_SESSION['last_generated_token_time']['login_form']>= $interval){
        $login_form_generated_token = bin2hex(random_bytes(16));
        $_SESSION['csrf_token']['login_form'] = $login_form_generated_token;
        $_SESSION['last_generated_token_time']['login_form'] = time();
    }
    else{
        $login_form_generated_token = $_SESSION['csrf_token']['login_form'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="login_form_body">
<div class="container">
        <div class="card mb-0 login_form_div">
            <h4 class="card-title login_form_heading">Login</h4>
            <div class="card-body card_body_login_form">
                    <div class="form-group">
                        <form action="login.php" method="post">
                        <input type="hidden" name="login_form_token" value="<?php echo $login_form_generated_token ?>">
                        <label class="login_username_form_label"><h6>Username</h6></label>
                        <input type="text" name="username" class="form-control" placeholder="Enter username" required autocomplete="off">
                        <label class="login_password_form_label"><h6>Password</h6></label>
                        <input type="text" name="password" class="form-control" placeholder="Enter password" required autocomplete="off">
                        <button type="submit" name="submit" id="login_form_btn"><span>LOGIN</span></button>
                        <?php
                        if(isset($_SESSION['Message_error'])){
                        ?>
                        <div class="alert alert-danger login_alert" role="alert">
                            <?php echo $_SESSION['Message_error'] ?>
                        </div>
                        <?php
                        unset($_SESSION['Message_error']);
                        }
                        ?>
                        </form>
                    </div>
            </div>
        </div>
</div>
</body>
</html>

