<?php
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if(!isset($_SESSION['USER_LOGIN'])){
?>
<script>
window.location.href="login.php";
</script>
<?php
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['edit_profile_form'])){
	$edit_profile_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['edit_profile_form'] = $edit_profile_form_generated_token;
	$_SESSION['last_generated_token_time']['edit_profile_form'] = time();
  }
  else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['edit_profile_form']>= $interval){
	  $edit_profile_form_generated_token = bin2hex(random_bytes(16));
	  $_SESSION['csrf_token']['edit_profile_form'] = $edit_profile_form_generated_token;
	  $_SESSION['last_generated_token_time']['edit_profile_form'] = time();
	}
	else{
	  $edit_profile_form_generated_token = $_SESSION['csrf_token']['edit_profile_form'];
	}
  }
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Profile</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
							<?php
							if(isset($_SESSION['Message'])){
							?>
							<div class="alert alert-success profile_updated_message" role="alert">
								<?php echo $_SESSION['Message'] ?>
							</div>
							<?php
							unset($_SESSION['Message']);
							}
							?>
		                	<div class="row">
		                		<div class="col-lg-6">
		                			<h2 class="checkout-title">PROFILE:</h2><!-- End .checkout-title -->
									<?php
									$user_id = $_SESSION['USER_ID'];
									$row = mysqli_fetch_assoc(mysqli_query($con, "select name, email, mobile from users where id='$user_id'"));
									?>
									<div class="row profile_name_div">
		                					<div class="col-sm-8" style="margin-bottom: 5px;">
		                						<label>Name *</label>
												<div class="name_edit_div">
		                						<input type="text" class="form-control name_edit_input" value="<?php echo $row['name'] ?>" disabled>&nbsp;
												<a role="button" class="edit_a_tag" data-toggle="modal" data-target="#edit_name_modal" data-keyboard="false" data-backdrop="static">Edit</a>
												</div>
		                					</div><!-- End .col-sm-4 -->
									</div><!-- End .row -->

									<input type="hidden" id="edit_profile_form_token" value="<?php echo $edit_profile_form_generated_token ?>">
								

									<!-- Modal start for editing name-->
									<div class="modal fade bootstrap_modal" id="edit_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Edit name</h5>
												<button type="button" class="close edit_modal_box_close_btn" data-dismiss="modal" aria-label="Close">
												<span class="edit_modal_box_close_btn_span" aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body edit_modal_box_modal_body">
												<form class="edit_name_form">
												<div class="form-group">
													<label for="New-name">Name *</label>
													<input type="text" class="form-control input_inside_modal_box" id="new_name" value="<?php echo $row['name'] ?>" required>
													<p class="field_error" id="new_name_error"></p>
												</div><!-- End .form-group -->
												<button type="button" onclick="update_new_name()" class="btn btn-outline-primary-2 new_name_btn">
														<span>SAVE</span>
														<!-- <i class="icon-long-arrow-right"></i> -->
												</button>
												</form>
											</div>
											</div>
										</div>
									</div>
									<!-- Modal end for editing name-->

									<div class="row profile_email_address_div">
                                            <div class="col-sm-8" style="margin-bottom: 5px;">
		                						<label>Email address *</label>
												<div class="email_address_edit_div">
		                						<input type="text" class="form-control email_address_edit_input" value="<?php echo $row['email'] ?>" disabled>&nbsp;
												<a role="button" class="edit_a_tag" data-toggle="modal" data-target="#edit_email_address_modal" data-keyboard="false" data-backdrop="static">Edit</a>
												</div>
		                					</div><!-- End .col-sm-4 -->
		                			</div><!-- End .row -->

									<!-- Modal start for editing email address-->
									<div class="modal fade bootstrap_modal" id="edit_email_address_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Edit email address</h5>
												<button type="button" class="close edit_modal_box_close_btn" data-dismiss="modal" aria-label="Close">
												<span class="edit_modal_box_close_btn_span" aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body edit_modal_box_modal_body">
												<form class="edit_email_address_form">
												<div class="form-group">
													<label for="New-email-address">Email address *</label>
													<input type="text" class="form-control input_inside_modal_box" id="new_email" value="<?php echo $row['email'] ?>" required>
													<p class="field_error" id="new_email_error"></p>
												</div><!-- End .form-group -->
										<button type="button" onclick="new_email_send_otp()" class="btn btn-outline-primary-2 new_email_send_otp_btn new_email_send_otp">
			                					<span>REQUEST OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>
										<div class="form-group new_email_verify_otp_div">
							    			<label for="New-email-address" class="new_email_verify_otp" style="display: none;">Enter OTP number *</label>&nbsp;
											<a role="button" onclick="new_email_resend_otp()" class="resend_otp_for_new_email resend_code_a_tag" style="display: none;">[Resend Code]</a>
							    			<input type="number" class="form-control input_inside_modal_box new_email_verify_otp" id="new_email_otp" style="display: none;" required>
											<p class="field_error" id="new_email_otp_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_email_verify_otp" role="alert"></div> -->
										
										<button type="button" onclick="new_email_verify_otp()" class="btn btn-outline-primary-2 new_email_verify_otp_btn new_email_verify_otp" style="display: none;">
			                					<span>VERIFY OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>
												</form>
											</div>
											</div>
										</div>
									</div>
									<!-- Modal end for editing email address-->

									<div class="row profile_mobile_number_div">
		                					<div class="col-sm-8" style="margin-bottom: 5px;">
		                						<label>Mobile number *</label>
												<div class="mobile_number_edit_div">
		                						<input type="number" class="form-control mobile_number_edit_input" value="<?php echo $row['mobile'] ?>" required disabled>&nbsp;
												<a role="button" class="edit_a_tag" data-toggle="modal" data-target="#edit_mobile_number_modal" data-keyboard="false" data-backdrop="static">Edit</a>
												</div>
		                					</div><!-- End .col-sm-4 -->
		                			</div><!-- End .row -->

									<!-- Modal start for editing mobile number-->
									<div class="modal fade bootstrap_modal" id="edit_mobile_number_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Edit mobile number</h5>
												<button type="button" class="close edit_modal_box_close_btn" data-dismiss="modal" aria-label="Close">
												<span class="edit_modal_box_close_btn_span" aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body edit_modal_box_modal_body">
												<form class="edit_mobile_number_form">
												<div class="form-group">
													<label for="New-mobile-number">Mobile number *</label>
													<input type="text" class="form-control input_inside_modal_box" id="new_mobile" value="<?php echo $row['mobile'] ?>" required>
													<p class="field_error" id="new_mobile_error"></p>
												</div><!-- End .form-group -->
										<button type="button" onclick="new_mobile_send_otp()" class="btn btn-outline-primary-2 new_mobile_send_otp_btn new_mobile_send_otp">
			                					<span>REQUEST OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>
										<div class="form-group new_mobile_verify_otp_div">
							    			<label for="New-mobile-number" class="new_mobile_verify_otp" style="display: none;">Enter OTP number *</label>&nbsp;
											<a role="button" onclick="new_mobile_resend_otp()" class="resend_otp_for_new_mobile resend_code_a_tag" style="display: none;">[Resend Code]</a>
							    			<input type="number" class="form-control input_inside_modal_box new_mobile_verify_otp" id="new_mobile_otp" style="display: none;" required>
											<p class="field_error" id="new_mobile_otp_error"></p>
							    		</div><!-- End .form-group -->
										<!-- <div class="alert" id="field_error_alert_email_verify_otp" role="alert"></div> -->
										
										<button type="button" onclick="new_mobile_verify_otp()" class="btn btn-outline-primary-2 new_mobile_verify_otp_btn new_mobile_verify_otp" style="display: none;">
			                					<span>VERIFY OTP</span>
			            						<!-- <i class="icon-long-arrow-right"></i> -->
			                			</button>
												</form>
											</div>
											</div>
										</div>
									</div>
									<!-- Modal end for editing mobile number-->
		                		</div><!-- End .col-lg-9 -->

								<div class="col-lg-6">
		                			<h2 class="checkout-title">CHANGE PASSWORD:</h2><!-- End .checkout-title -->

									<div class="row">
		                					<div class="col-sm-8" style="margin-bottom: 5px;">
		                						<label>Current Password *</label>
		                						<input type="password" class="form-control profile_password_field" id="current_password" required>
												<p class="field_error" id="current_password_error"></p>
		                					</div><!-- End .col-sm-4 -->
									</div><!-- End .row -->

									<div class="row">
                                            <div class="col-sm-8" style="margin-bottom: 5px;">
		                						<label class="new_password_label">New Password *</label>
		                						<input type="password" class="form-control profile_password_field" id="new_password" required>
												<p class="field_error" id="new_password_error"></p>
		                					</div><!-- End .col-sm-4 -->
		                			</div><!-- End .row -->

									<div class="row">
		                					<div class="col-sm-8" style="margin-bottom: 5px;">
		                						<label class="confirm_password_label">Confirm Password *</label>
		                						<input type="password" class="form-control profile_password_field" id="confirm_password" required>
												<p class="field_error" id="confirm_password_error"></p>
		                					</div><!-- End .col-sm-4 -->
		                			</div><!-- End .row -->

                                            <button type="button" onclick="update_password()" class="btn btn-outline-primary-2 btn-minwidth-sm profile_page_update_password_btn">
                                                <span>CHANGE</span>
                                            </button>
		                		</div><!-- End .col-lg-9 -->
		                	</div><!-- End .row -->
            		
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

<?php
require('footer.php');
?>