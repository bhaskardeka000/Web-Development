<?php 
require('top.php');
$token = $_GET['token'];
$check_token = mysqli_query($con, "select * from users where reset_token = '$token'");
$fetched_user = mysqli_fetch_assoc($check_token);

if(mysqli_num_rows($check_token)<1 || !isset($_GET['token']) || $_GET['token']=='' || (time() - $fetched_user['reset_token_expires_at'] >= 60 * 20)){
	mysqli_query($con, "update users set reset_token = null, reset_token_expires_at = null where reset_token = '$token'");
?>
<script>
alert("Invalid token or token expired. You will be redirected to the forgot password page.");
window.location.href = "forgot_password.php";
</script>
<?php
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['reset_password_form'])){
	$reset_password_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['reset_password_form'] = $reset_password_form_generated_token;
	$_SESSION['last_generated_token_time']['reset_password_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['reset_password_form']>= $interval){
		$reset_password_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['reset_password_form'] = $reset_password_form_generated_token;
		$_SESSION['last_generated_token_time']['reset_password_form'] = time();
	}
	else{
		$reset_password_form_generated_token = $_SESSION['csrf_token']['reset_password_form'];
	}
}
?>

<main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Reset Password</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="reset_password.php?token=<?php echo $token; ?>">Reset Password</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-color: white;">
            	<div class="container">
            		<div class="form-box">
            			<div class="form-tab">
	            			<ul class="nav nav-pills nav-fill" role="tablist">
							    <li class="nav-item">
							        <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2">Create New Password</a>
							    </li>
							</ul>
							<div class="tab-content">
							    <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
							    	<form action="#" id="reset_password_form">
										<input type="hidden" id="reset_password_form_token" value="<?php echo $reset_password_form_generated_token ?>">
							    		<div class="form-group">
							    			<label for="singin-email-2">New Password *</label>
							    			<input type="password" class="form-control" id="new_password" name="new_password" required>
											<p class="field_error" id="new_password_error"></p>
							    		</div><!-- End .form-group -->

							    		<div class="form-group">
							    			<label for="singin-password-2">Confirm Password *</label>
							    			<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
											<p class="field_error" id="confirm_password_error"></p>
							    		</div><!-- End .form-group -->

										<input type="hidden" id="token" value="<?php echo $token ?>">

							    		<div class="form-footer change_msg">
							    			<button type="button" onclick="reset_password()" class="btn btn-outline-primary-2" style="margin-bottom: 10px; padding: 12px 15px;">
			                					<span>RESET PASSWORD</span>
			                				</button>
											<div class="alert" id="field_final_alert_in_reset_password" role="alert"></div>
												<!-- <p class="form-messege field_error" style="color: #53ad44;"></p> -->
							    		</div><!-- End .form-footer -->
							    	</form>
							    </div><!-- .End .tab-pane -->
							</div><!-- End .tab-content -->
						</div><!-- End .form-tab -->
            		</div><!-- End .form-box -->
            	</div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->
<?php 
require('footer.php');
?>