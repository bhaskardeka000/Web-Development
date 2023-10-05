<?php
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['contact_us_form'])){
	$contact_us_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['contact_us_form'] = $contact_us_form_generated_token;
	$_SESSION['last_generated_token_time']['contact_us_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['contact_us_form']>= $interval){
		$contact_us_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['contact_us_form'] = $career_form_generated_token;
		$_SESSION['last_generated_token_time']['contact_us_form'] = time();
	}
	else{
		$contact_us_form_generated_token = $_SESSION['csrf_token']['contact_us_form'];
	}
}
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Contact Us</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="contact_us.php">Contact Us</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div id="map" class="mb-5">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3581.477668893254!2d91.78174182534434!3d26.148568630567684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375a597cb8073499%3A0x59900dedc3ca05d6!2sMcDonald&#39;s!5e0!3m2!1sen!2sin!4v1675351254623!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div><!-- End #map -->
                <div class="container">
                	<div class="row">
                		<div class="col-md-4">
                			<div class="contact-box text-center">
        						<h3>Office Address</h3>

        						<address>Nandanpur Path, Beltola Tiniali, Guwahati,<br>781028, Assam,<br>India</address>
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->

                		<div class="col-md-4">
                			<div class="contact-box text-center">
        						<h3>Opening Hour</h3>

        						<div><a>Monday - Saturday: 10:00AM - 05:00PM</a></div>
        						<div><a>Sunday: Closed</a></div>
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->

                		<div class="col-md-4">
                			<div class="contact-box text-center">
        						<h3>Phone Number</h3>

        						<div><a>1234567890, 2233445566</a></div>
        					</div><!-- End .contact-box -->
                		</div><!-- End .col-md-4 -->
                	</div><!-- End .row -->

                	<hr class="mt-3 mb-5 mt-md-1">
                	<div class="touch-container row" style="justify-content: center;">
                		<div class="col-md-9 col-lg-7">
                			<div class="text-center" style="margin-bottom: 30px;">
                			<h1 class="title mb-1">Get In Touch</h1><!-- End .title mb-2 -->
                			</div><!-- End .text-center -->

                			<form action="#" method="post" class="contact-form mb-2" id="contact_us_form">
								<input type="hidden" id="contact_us_form_token" value="<?php echo $contact_us_form_generated_token ?>">
                				<div class="row">
                					<div class="col-sm-6" style="margin-bottom: 2rem;">
                						<input type="text" class="form-control" id="name" placeholder="Your Name *" style="margin-bottom: 0;">
										<p class="field_error" id="name_error"></p>
									</div><!-- End .col-sm-4 -->

                					<div class="col-sm-6" style="margin-bottom: 2rem;">
                						<input type="number" class="form-control" id="mobile" placeholder="Your mobile number *" style="margin-bottom: 0;">
										<p class="field_error" id="mobile_error"></p>
                					</div><!-- End .col-sm-4 -->
                				</div><!-- End .row -->

								<div class="form-group" style="margin-bottom: 2.5rem;">
                						<input type="email" class="form-control" id="email" placeholder="Your email address *" style="margin-top: 0.5rem; margin-bottom: 0;">
										<p class="field_error" id="email_error"></p>
								</div><!-- End .form-group -->

								<div class="form-group" style="margin-bottom: 3rem;">
									<textarea class="form-control" cols="30" rows="4" id="message" placeholder="Type your Message *" style="margin-top: 0.5rem; margin-bottom: 0;"></textarea>
									<p class="field_error" id="message_error"></p>
								</div><!-- End .form-group -->
								
								<div class="text-center" style="text-align: left !important;">
	                				<button type="button" onclick="send_message()" class="btn btn-outline-primary-2 btn-minwidth-sm send_message_button" style="margin-bottom: 2rem;">
	                					<span>SEND MESSAGE</span>
	            						<i class="icon-long-arrow-right"></i>
	                				</button>
									<div class="alert" id="field_final_alert_in_contact_us" role="alert"></div>
                				</div><!-- End .text-center -->
                			</form><!-- End .contact-form -->
                		</div><!-- End .col-md-9 col-lg-7 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

<?php
require('footer.php');
?>