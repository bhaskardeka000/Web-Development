<head>
<style>
.category_click:hover, .account_click:hover, .mmenu-btn:hover{
color: #85004b !important;
}
.notification_count{
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute !important;
    right: 1rem;
    top: 50%;
    z-index: 10;
    /* width: 3rem; */
    width: 2.3rem;
    /* height: 3rem; */
    height: 2.3rem;
    font-size: 1.2rem;
    /* color: black;  */
    margin-top: -1.5rem;
    border-radius: 0;
    /* background-color: transparent;  */
    cursor: pointer;
    outline: none;
    transition: color 0.35s;
    background-color: #f0f0f0;
    color: #878787;
}
</style>
</head>

<footer class="footer footer-2">
        	<div class="footer-middle">
	            <div class="container">
	            	<div class="row">
	            		<div class="col-sm-12 col-lg-6">
	            			<div class="widget widget-about">
	            				<img src="assets/images/demos/demo-2/logo.png" class="footer-logo" alt="Footer Logo" width="105" height="25">
	            				<p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. </p>
	            				
	            				<div class="widget-about-info">
	            					<div class="row">
	            						<div class="col-sm-6 col-md-4">
	            							<span class="widget-about-title">Got Question? Call us 24/7</span>
	            							<a href="tel:123456789">+0123 456 789</a>
	            						</div><!-- End .col-sm-6 -->
	            						<div class="col-sm-6 col-md-8">
	            							<span class="widget-about-title">Payment Method</span>
	            							<figure class="footer-payments">
							        			<img src="assets/images/payments.png" alt="Payment methods" width="272" height="20">
							        		</figure><!-- End .footer-payments -->
	            						</div><!-- End .col-sm-6 -->
	            					</div><!-- End .row -->
	            				</div><!-- End .widget-about-info -->
	            			</div><!-- End .widget about-widget -->
	            		</div><!-- End .col-sm-12 col-lg-3 -->

	            		<div class="col-sm-4 col-lg-2">
	            			<div class="widget">
	            				<h4 class="widget-title">Information</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="about.html">About Molla</a></li>
	            					<li><a href="#">How to shop on Molla</a></li>
	            					<li><a href="#">FAQ</a></li>
	            					<li><a href="contact.html">Contact us</a></li>
	            					<li><a href="login.html">Log in</a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-4 col-lg-3 -->

	            		<div class="col-sm-4 col-lg-2">
	            			<div class="widget">
	            				<h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="#">Payment Methods</a></li>
	            					<li><a href="#">Money-back guarantee!</a></li>
	            					<li><a href="#">Returns</a></li>
	            					<li><a href="#">Shipping</a></li>
	            					<li><a href="#">Terms and conditions</a></li>
	            					<li><a href="#">Privacy Policy</a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-4 col-lg-3 -->

	            		<div class="col-sm-4 col-lg-2">
	            			<div class="widget">
	            				<h4 class="widget-title">My Account</h4><!-- End .widget-title -->

	            				<ul class="widget-list">
	            					<li><a href="#">Sign In</a></li>
	            					<li><a href="cart.html">View Cart</a></li>
	            					<li><a href="#">My Wishlist</a></li>
	            					<li><a href="#">Track My Order</a></li>
	            					<li><a href="#">Help</a></li>
	            				</ul><!-- End .widget-list -->
	            			</div><!-- End .widget -->
	            		</div><!-- End .col-sm-64 col-lg-3 -->
	            	</div><!-- End .row -->
	            </div><!-- End .container -->
	        </div><!-- End .footer-middle -->

	        <div class="footer-bottom">
	        	<div class="container">
	        		<p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p><!-- End .footer-copyright -->
	        		<ul class="footer-menu">
	        			<li><a href="#">Terms Of Use</a></li>
	        			<li><a href="#">Privacy Policy</a></li>
	        		</ul><!-- End .footer-menu -->

	        		<div class="social-icons social-icons-color">
	        			<span class="social-label">Social Media</span>
    					<a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
    					<a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
    					<a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
    					<a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
    					<a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
    				</div><!-- End .soial-icons -->
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <!-- <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button> -->

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container mobile-menu-light">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>
            
            <div>
            <form action="search.php" method="get" class="mobile-search">
                <label for="q" class="sr-only">Search</label>
                <input type="search" class="form-control" name="str" id="qr" placeholder="Search for products ..." required autocomplete="off" onfocus="show_mobile_suggestion_box()" onblur="hide_mobile_suggestion_box()">
                <button class="btn btn-primary" type="submit"><i class="icon-search search-mobile-icon"></i></button>
            </form>
            </div>
            <div class="list-group" id="show-list-mobile">
            <!-- Display suggestion/autocomplete box(For mobile type screen) here -->
            </div>

            <ul class="nav nav-pills-mobile nav-border-anim" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mobile-menu-link" data-toggle="tab" role="tab" aria-controls="mobile-menu-tab" aria-selected="true">Menu</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel" aria-labelledby="mobile-menu-link">
                    <nav class="mobile-nav">
                        <ul class="mobile-menu">
                            <li class="active">
                                <a href="index.php">Home</a>
                            </li>
                            <li>
                                <a class="category_click" style="cursor: pointer;">All Categories</a>
                                <ul>
                                <?php
                                foreach($cat_arr as $list){
                                ?>
                                    <li><a href="categories.php?id= <?php echo encrypt_id($list['id']) ?>" style="text-transform: uppercase;"> <?php echo $list['categories']?> </a></li>
                                <?php
                                }
                                ?>
                                </ul>
                            </li>
                            <li>
                                <a href="all_products.php" class="sf-with-ul">All Products</a>
                            </li>
                            <li>
                            <?php
                            if(isset($_SESSION['USER_LOGIN'])){
                                $user_id = $_SESSION['USER_ID'];
                                $res = mysqli_query($con, "select * from notifications where user_id = '$user_id' and status = 0");
                                $notification_co = mysqli_num_rows($res);
                            ?>

                                <a class="account_click" style="cursor: pointer;">Account</a>
                                <ul>
                                    <li><a href="my_orders.php">MY ORDERS</a></li>
                                    <li><a href="profile.php">PROFILE</a></li>
                                    <input type="hidden" id="user_id" value="<?php echo $user_id ?>">
                                    <li><a href="notifications.php" id="notification_click_mobile">NOTIFICATIONS<span class="notification_count"><?php echo $notification_co ?></span></a></li>
                                    <li><a href="logout.php">LOGOUT</a></li>
                                </ul>

                            <?php
                            }
                            else{
                            echo "<a href='login.php'>LOGIN</a>";
                            }
                        ?>
                            </li>
                            <li>
                                <a href="career.php">Career</a>
                            </li>
                            <li>
                                <a href="contact_us.php">Contact Us</a>
                            </li>
                            <li>
                                <a href="partner_with_us.php">Partner With Us</a>
                            </li>
                        </ul>
                    </nav><!-- End .mobile-nav -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    


    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>
    <!-- <script src="assets/js/bootstrap-input-spinner.js"></script> -->
    <script src="assets/js/jquery.elevateZoom.min.js"></script>
    <!-- <script src="assets/js/bootstrap-input-spinner.js"></script> -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-2.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="http://cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="age_verification_assets/js/age-verification.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>


<!-- molla/index-1.html  22 Nov 2019 09:55:32 GMT -->
</html>