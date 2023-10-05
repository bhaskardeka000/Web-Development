<?php
require('top.php');

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['partner_with_us_form'])){
	$partner_with_us_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['partner_with_us_form'] = $partner_with_us_form_generated_token;
	$_SESSION['last_generated_token_time']['partner_with_us_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['partner_with_us_form']>= $interval){
		$partner_with_us_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['partner_with_us_form'] = $career_form_generated_token;
		$_SESSION['last_generated_token_time']['partner_with_us_form'] = time();
	}
	else{
		$partner_with_us_form_generated_token = $_SESSION['csrf_token']['partner_with_us_form'];
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

input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}

input[type="checkbox"] {
  height: 1.2em;
  width: 1.5em;
  vertical-align: middle;
}

.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #f9f9f9 !important;
    border: 1px solid #dadada !important;

}

.custom-checkbox .custom-control-label::after{
    color: #777 !important;
}

.checkout .form-control:not(:focus) {
    background-color: #ffffff;
}
    </style>
</head>
<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Partner With Us</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="partner_with_us.php">Partner With Us</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
            				<form id="partnership_form">
							<input type="hidden" id="partner_with_us_form_token" value="<?php echo $partner_with_us_form_generated_token ?>">
		                	<div class="row">
							<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title" style="padding-bottom: 10px; margin-bottom: 5px;">Note:</h3><!-- End .summary-title -->
										<p>An individual, company, organization, brand can now partner with us and provide the products to us. Scotch Club International will sell the products through the website.</p>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Fill up the required details:</h2><!-- End .checkout-title -->
		                			
									<div class="form-group" style="margin-bottom: 0;">
										<label>Name (Individual / Company / Organization / Brand) *</label>
										<input type="text" class="form-control" id="name" name="name" required style="margin-bottom: 0;">
										<p class="field_error" id="name_error"></p>
							    	</div><!-- End .form-group -->

									<div class="row">

                                            <div class="col-sm-6">
		                						<label style="margin-top: 1.3rem;">Email address *</label>
		                						<input type="email" class="form-control" id="email" name="email" required style="margin-bottom: 0;">
												<p class="field_error" id="email_error"></p>
		                					</div><!-- End .col-sm-4 -->

		                					<div class="col-sm-6">
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
		                						<input type="text" class="form-control partner_with_us_state_name" id="state" name="state" required style="margin-bottom: 0;">
												<p class="field_error" id="state_error"></p>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

										<div class="row">
											<div class="col-sm-6">
												<label style="margin-top: 1.3rem;">GST / Pan Card (Any One) *</label>
												<select class="form-control" style="width: 100%;
												margin-bottom: 0;" id="gst_pan_card" name="gst_pan_card" onchange="gst_pan_card_check(this)" required> 
													<option value="">Select</option>
													<option value="GST">GST</option>
													<option value="Pan Card">Pan Card</option>
												</select>
												<p class="field_error" id="gst_pan_card_error"></p>
											</div><!-- End .col-sm-6 -->

											<div class="col-sm-6">
												<label style="margin-top: 1.3rem;">Number *</label>
												<input type="text" class="form-control" id="gst_pan_card_number" name="gst_pan_card_number" required style="margin-bottom: 0;">
												<p class="field_error" id="gst_pan_card_number_error"></p>
											</div><!-- End .col-sm-6 -->
										</div><!-- End .row -->

										<div class="row">
											<div class="col-sm-6">
												<label style="margin-top: 1.3rem;">FSSAI License / Trade License / Others (Any One) *</label>
												<select class="form-control" style="width: 100%; margin-bottom: 0;" id="license" name="license" onchange="license_check(this)" required> 
													<option value="">Select</option>
													<option value="FSSAI License">FSSAI License</option>
													<option value="Trade License">Trade License</option>
													<option value="Other License">Any Other License</option>
												</select>
												<p class="field_error" id="license_error"></p>
											</div><!-- End .col-sm-6 -->

											<div class="col-sm-6">
												<label style="margin-top: 1.3rem;">Number *</label>
												<input type="text" class="form-control" id="license_number" name="license_number" required style="margin-bottom: 0;">
												<p class="field_error" id="license_number_error"></p>
											</div><!-- End .col-sm-6 -->
										</div><!-- End .row -->

										<div class="form-group" style="margin-bottom: 0;">
										<label style="margin-top: 1.3rem;">Applied for *</label>
												<select class="form-control" style="width: 100%; margin-bottom: 0;" id="applied_for" name="applied_for" required> 
													<option value="">Select</option>
													<option value="Super Stockist">Super Stockist</option>
													<option value="Distributor">Distributor</option>
													<option value="Wholesaler">Wholesaler</option>
													<option value="Retailer">Retailer</option>
												</select>
												<p class="field_error" id="applied_for_error"></p>
										</div><!-- End .form-group -->

										<div class="row">
											<div class="col-sm-6">
												<label style="margin-top: 1.3rem;">Referred by *</label>
												<input type="text" class="form-control" placeholder="Enter name who recommended us" id="referred_by" name="referred_by" required style="margin-bottom: 0;">
												<p class="field_error" id="referred_by_error"></p>
											</div><!-- End .col-sm-6 -->

											<div class="col-sm-6">
												<label style="margin-top: 1.3rem;">Start business from *</label>
												<input type="date" class="form-control" id="business_start_date" name="business_start_date" min="2023-01-01" required style="margin-bottom: 0;">
												<p class="field_error" id="business_start_date_error"></p>
											</div><!-- End .col-sm-6 -->
										</div><!-- End .row -->

	        							<div class="custom-control custom-checkbox" style="margin-top: 3.8rem;">
											<input type="checkbox" class="custom-control-input" id="declared_checkbox" value="declared">
											<label class="custom-control-label" for="declared_checkbox" style="cursor: pointer; color: #777; margin-bottom: 0;">I hereby declare that information provided above is true and correct in every respect and in case any information is found incorrect even partially the partnership request shall be liable to be rejected.</label>
											<p class="field_error" id="declaration_error"></p>
										</div><!-- End .custom-checkbox -->

										<div class="form-footer">
											<button type="button" onclick="request_partner_with_us()" class="btn btn-outline-primary-2 btn-minwidth-sm" style="margin-top: 1.3rem; margin-bottom: 2rem;"><!-- 2.2rem changed to 1.3rem -->
											<span>SEND REQUEST</span>
											<i class="icon-long-arrow-right"></i>
											</button>
											<div class="alert" id="field_final_alert_in_partner_with_us" role="alert"></div>
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