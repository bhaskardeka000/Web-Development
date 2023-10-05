<?php
require('top.php');

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['career_form'])){
	$career_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['career_form'] = $career_form_generated_token;
	$_SESSION['last_generated_token_time']['career_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['career_form']>= $interval){
		$career_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['career_form'] = $career_form_generated_token;
		$_SESSION['last_generated_token_time']['career_form'] = time();
	}
	else{
		$career_form_generated_token = $_SESSION['csrf_token']['career_form'];
	}
}
?>
<head>
<style>
SELECT {
    background: url("data:image/svg+xml,<svg height='10px' width='10px' viewBox='0 0 16 16' fill='%23000000' xmlns='http://www.w3.org/2000/svg'><path d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/></svg>") no-repeat;
    background-position: calc(100% - 0.75rem) center !important;
    -moz-appearance:none !important;
    -webkit-appearance: none !important; 
    appearance: none !important;
    padding-right: 2rem !important;
}

.checkout .form-control:not(:focus) {
    background-color: #ffffff;
}
    </style>
</head>
<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Career</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="career.php">Career</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
		                	<div class="row">
							<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Job Opening:</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                					<thead>
		                						<tr>
		                							<th style="text-align: left;">Current Job Openings:</th>
		                						</tr>
		                					</thead>

		                					<tbody>
		                						<tr>
		                							<td style="text-align: left; width: 100%; height: 50px; border-bottom: 0;"><a href="#">1. Intern for Software Development</a></td>
		                						</tr>

		                						<tr>
		                							<td style="text-align: left; width: 100%; height: 50px; border-bottom: 0;"><a href="#">2. Intern for Document Management System</a></td>
		                						</tr>
		                					</tbody>
		                				</table><!-- End .table table-summary -->
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Fill up the required details:</h2><!-- End .checkout-title -->
									
							<form action="#" method="post" class="contact-form mb-2" id="career_application_form">
									<input type="hidden" id="career_form_token" value="<?php echo $career_form_generated_token ?>">
									<div class="form-group" style="margin-bottom: 0;">
										<label>Applying for the post of *</label>
										<input type="text" class="form-control" id="post_name" name="post_name" required style="margin-bottom: 0;">
										<p class="field_error" id="post_name_error"></p>
									</div><!-- End .form-group -->

									<div class="row">
		                					<div class="col-sm-4">
		                						<label style="margin-top: 1.3rem;">Name *</label>
		                						<input type="text" class="form-control" id="name" name="name" required style="margin-bottom: 0;">
												<p class="field_error" id="name_error"></p>
											</div><!-- End .col-sm-4 -->

                                            <div class="col-sm-4">
		                						<label style="margin-top: 1.3rem;">Email address *</label>
		                						<input type="email" class="form-control" id="email" name="email" required style="margin-bottom: 0;">
												<p class="field_error" id="email_error"></p>
											</div><!-- End .col-sm-4 -->

		                					<div class="col-sm-4">
		                						<label style="margin-top: 1.3rem;">Mobile Number *</label>
		                						<input type="number" class="form-control" id="mobile" name="mobile" required style="margin-bottom: 0;">
												<p class="field_error" id="mobile_error"></p>
											</div><!-- End .col-sm-4 -->
		                				</div><!-- End .row -->

										<div class="form-group" style="margin-bottom: 0;">
											<label style="margin-top: 1.3rem;">Full address *</label>
											<input type="text" class="form-control" id="address" name="address" required style="margin-bottom: 0;">
											<p class="field_error" id="address_error"></p>
										</div><!-- End .form-group -->

		                				<div class="row">
										<div class="col-sm-6">
		                						<label style="margin-top: 1.3rem;">Pincode *</label>
		                						<input type="number" class="form-control" id="pincode" name="pincode" required style="margin-bottom: 0;">
												<p class="field_error" id="pincode_error"></p>
		                					</div><!-- End .col-sm-6 -->
											
		                					<div class="col-sm-6">
		                						<label style="margin-top: 1.3rem;">State *</label>
		                						<input type="text" class="form-control career_application_state_name" id="state" name="state" required style="margin-bottom: 0;">
												<p class="field_error" id="state_error"></p>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

										<div class="form-group" style="margin-bottom: 0;">
											<label style="margin-top: 1.3rem;">Gender *</label>
											<select class="form-control" style="width: 100%; margin-bottom: 0;" id="gender" name="gender" required> 
												<option value="">Select Gender</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
												<option value="Others">Others</option>
											</select>
											<p class="field_error" id="gender_error"></p>
										</div><!-- End .form-group -->

										<div class="form-group" style="margin-bottom: 0;">
	                					<label style="margin-top: 1.3rem;">Resume(Please upload your updated resume) *</label>
	        							<input type="file" class="form-control" style="height: 45px; margin-bottom: 0;" id="resume" name="resume" required>
										<p class="field_error" id="resume_error"></p>
										</div><!-- End .form-group -->

										<div class="form-footer">
                                            <button type="button" onclick="send_career_application()" class="btn btn-outline-primary-2 btn-minwidth-sm" style="margin-top: 2.3rem; margin-bottom: 2rem;">
                                                <span>SUBMIT APPLICATION</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
											<div class="alert" id="field_final_alert_in_career" role="alert"></div>
										</div><!-- End .form-footer -->
		                		</div><!-- End .col-lg-9 -->
                        	</form>       
		                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

<?php
require('footer.php');
?>