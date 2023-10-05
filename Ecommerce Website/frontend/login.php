<?php 
require('top.php');
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes'){
?>
<script>
window.location.href="<?php echo $_SESSION['url'] ?>";
</script>
<?php
die();
}

	if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['login_form'])){
		$login_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['login_form'] = $login_form_generated_token;
		$_SESSION['last_generated_token_time']['login_form'] = time();
	}
	else{
		$interval = 60 * 15;
		if(time() -  $_SESSION['last_generated_token_time']['login_form']>= $interval){
			$login_form_generated_token = bin2hex(random_bytes(16));
			$_SESSION['csrf_token']['login_form'] = $login_form_generated_token;
			$_SESSION['last_generated_token_time']['login_form'] = time();
		}
		else{
			$login_form_generated_token = $_SESSION['csrf_token']['login_form'];
		}
	}
	
	if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['registration_form'])){
		$registration_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['registration_form'] = $registration_form_generated_token;
		$_SESSION['last_generated_token_time']['registration_form'] = time();
	}
	else{
		$interval = 60 * 15;
		if(time() -  $_SESSION['last_generated_token_time']['registration_form']>= $interval){
			$registration_form_generated_token = bin2hex(random_bytes(16));
			$_SESSION['csrf_token']['registration_form'] = $registration_form_generated_token;
			$_SESSION['last_generated_token_time']['registration_form'] = time();
		}
		else{
			$registration_form_generated_token = $_SESSION['csrf_token']['registration_form'];
		}
	}

	if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['email_and_mobile_verification_form'])){
		$email_and_mobile_verification_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['email_and_mobile_verification_form'] = $email_and_mobile_verification_form_generated_token;
		$_SESSION['last_generated_token_time']['email_and_mobile_verification_form'] = time();
	}
	else{
		$interval = 60 * 15;
		if(time() -  $_SESSION['last_generated_token_time']['email_and_mobile_verification_form']>= $interval){
			$email_and_mobile_verification_form_generated_token = bin2hex(random_bytes(16));
			$_SESSION['csrf_token']['email_and_mobile_verification_form'] = $email_and_mobile_verification_form_generated_token;
			$_SESSION['last_generated_token_time']['email_and_mobile_verification_form'] = time();
		}
		else{
			$email_and_mobile_verification_form_generated_token = $_SESSION['csrf_token']['email_and_mobile_verification_form'];
		}
	}
?>

<main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Login</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="login.php">Login</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-color: white;">
            	<div class="container">
            		<div class="form-box">
            			<div class="form-tab">
	            			<ul class="nav nav-pills nav-fill" role="tablist">
							    <li class="nav-item">
							        <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2">Login</a>
							    </li>
							    <li class="nav-item">
							        <a class="nav-link" id="register-tab-2" data-toggle="tab" href="#register-2" role="tab" aria-controls="register-2">Register</a>
							    </li>
							</ul>
							<div class="tab-content">
							    <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
							    	<form action="#">
										<input type="hidden" id="login_form_token" value="<?php echo $login_form_generated_token ?>">
							    		<div class="form-group">
							    			<label for="singin-email-2">Your email address *</label>
							    			<input type="text" class="form-control" id="login_email" name="singin-email">
											<p class="field_error" id="login_email_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_login_email" role="alert"></div> -->

							    		<div class="form-group">
							    			<label for="singin-password-2">Password *</label>
							    			<input type="password" class="form-control" id="login_password" name="singin-password">
											<p class="field_error" id="login_password_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_login_password" role="alert"></div> -->

							    		<div class="form-footer login_msg">
							    			<button type="button" onclick="user_login()" class="btn btn-outline-primary-2" style="margin-bottom: 10px;">
			                					<span>LOGIN</span>
			            						<i class="icon-long-arrow-right"></i>
			                				</button>
												<div class="alert" id="field_final_alert_in_login" role="alert"></div>
											<a href="forgot_password.php" class="forgot-link">Forgot Your Password?</a>
							    		</div><!-- End .form-footer -->
							    	</form>
							    </div><!-- .End .tab-pane -->
							    <div class="tab-pane fade" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
							    	<form action="#" id="register_form">
										<input type="hidden" id="registration_form_token" value="<?php echo $registration_form_generated_token ?>">
										<input type="hidden" id="email_and_mobile_verification_form_token" value="<?php echo $email_and_mobile_verification_form_generated_token ?>">
										<div class="form-group">  <!-- email verification part starts here -->
											<label for="register-email-2">Your email address *</label>
							    			<input type="text" class="form-control" id="email" name="register-email" required>
											<p class="field_error" id="email_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_email_send_otp" role="alert"></div> -->
										
										<button type="button" onclick="email_send_otp()" class="btn btn-outline-primary-2 email_send_otp" style="margin-bottom: 10px; padding: 12px 15px;">
			                					<span>REQUEST OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>

										<div class="form-group email_verify_otp_div">
							    			<label for="register-email-2" class="email_verify_otp" style="display: none;">Enter OTP number *</label>&nbsp;
											<a role="button" onclick="email_resend_otp()" class="resend_otp_for_email resend_code_a_tag" style="display: none;">[Resend Code]</a>
							    			<input type="number" class="form-control email_verify_otp" id="email_otp" name="register-email" style="display: none;" required>
											<p class="field_error" id="email_otp_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_email_verify_otp" role="alert"></div> -->
										
										<button type="button" onclick="email_verify_otp()" class="btn btn-outline-primary-2 email_verify_otp" style="margin-bottom: 10px; padding: 12px 15px; display: none;">
			                					<span>VERIFY OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>
										<p class="form-messege field_error email_otp_result" style="color: #53ad44;"></p>
										<!-- <div class="alert" id="field_verified_alert_email_verify_otp" role="alert"></div> -->
                                        <!-- email verification part ends here -->

                                        <div class="form-group"> <!-- MobileNo verification part starts here -->
							    			<label for="register-email-2">Your mobile number *</label>
							    			<input type="number" class="form-control" id="mobile" name="register-email" required>
											<p class="field_error" id="mobile_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_mobile_send_otp" role="alert"></div> -->

										<button type="button" onclick="mobile_send_otp()" class="btn btn-outline-primary-2 mobile_send_otp" style="margin-bottom: 10px; padding: 12px 15px;">
			                					<span>REQUEST OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>

										<div class="form-group mobile_verify_otp_div">
							    			<label for="register-email-2" class="mobile_verify_otp" style="display: none;">Enter OTP number *</label>&nbsp;
											<a role="button" onclick="mobile_resend_otp()" class="resend_otp_for_mobile resend_code_a_tag" style="display: none;">[Resend Code]</a>
							    			<input type="number" class="form-control mobile_verify_otp" id="mobile_otp" name="register-email" style="display: none;" required>
											<p class="field_error" id="mobile_otp_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_mobile_verify_otp" role="alert"></div> -->

										<button type="button" onclick="mobile_verify_otp()" class="btn btn-outline-primary-2 mobile_verify_otp" style="margin-bottom: 10px; padding: 12px 15px; display: none;">
			                					<span>VERIFY OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>
										<p class="form-messege field_error mobile_otp_result" style="color: #53ad44;"></p>
										<!-- <div class="alert" id="field_verified_alert_mobile_verify_otp" role="alert"></div> -->
										<!-- MobileNo verification part ends here -->
										
                                        <div class="form-group">
							    			<label for="register-email-2">Your name *</label>
							    			<input type="text" class="form-control" id="name" name="register-email" required>
											<p class="field_error" id="name_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="name_field_error_alert" role="alert"></div> -->

							    		<div class="form-group">
							    			<label for="register-password-2">Password *</label>
							    			<input type="password" class="form-control" id="password" name="register-password" required>
											<p class="field_error" id="password_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="password_field_error_alert" role="alert"></div> -->

							    		<div class="form-footer register_msg">
							    			<button type="button" onclick="user_register()" class="btn btn-outline-primary-2 btn_register" style="margin-bottom: 10px;" disabled>
			                					<span>REGISTER</span>
			            						<i class="icon-long-arrow-right"></i>
			                				</button>
											<div class="alert" id="field_final_alert_in_register" role="alert"></div>
							    		</div><!-- End .form-footer -->
							    	</form>
							    </div><!-- .End .tab-pane -->
							</div><!-- End .tab-content -->
						</div><!-- End .form-tab -->
            		</div><!-- End .form-box -->
            	</div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->
<input type="hidden" id="is_email_verified">
<input type="hidden" id="is_mobile_verified">
<?php 
require('footer.php');
?>