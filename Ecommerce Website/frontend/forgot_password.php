<?php 
require('top.php');

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['send_password_reset_link_form'])){
	$send_password_reset_link_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['send_password_reset_link_form'] = $send_password_reset_link_form_generated_token;
	$_SESSION['last_generated_token_time']['send_password_reset_link_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['send_password_reset_link_form']>= $interval){
		$send_password_reset_link_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['send_password_reset_link_form'] = $send_password_reset_link_form_generated_token;
		$_SESSION['last_generated_token_time']['send_password_reset_link_form'] = time();
	}
	else{
		$send_password_reset_link_form_generated_token = $_SESSION['csrf_token']['send_password_reset_link_form'];
	}
}
?>

<main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Forgot Password</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="recover_password.php">Forgot Password</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-color: white;">
            	<div class="container">
            		<div class="form-box">
            			<div class="form-tab">
	            			<ul class="nav nav-pills nav-fill" role="tablist">
							    <li class="nav-item">
							        <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2">Reset Password</a>
							    </li>
							</ul>
							<div class="tab-content">
							    <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
							    	<form action="#">
							    		<div class="form-group">
											<input type="hidden" id="send_password_reset_link_form_token" value="<?php echo $send_password_reset_link_form_generated_token ?>">
							    			<label for="singin-email-2">Your email address *</label>
							    			<input type="text" class="form-control" id="email" name="singin-email">
											<p class="field_error" id="reset_email_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_email_in_recover_password" role="alert"></div> -->

							    		<div class="form-footer reset_msg">
							    			<button type="button" onclick="send_password_reset_link()" class="btn btn-outline-primary-2 reset_password_link" style="margin-bottom: 10px; padding: 12px 15px;">
			                					<span>SEND PASSWORD RESET LINK</span>
			                				</button>
											<div class="alert" id="field_final_alert_in_recover_password" role="alert"></div>
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