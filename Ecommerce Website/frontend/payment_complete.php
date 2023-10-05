<?php 
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Thank You</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="thank_you.php">Thank You</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

          
                <div class="container">
                	<div class="row">
                		<div class="col-lg-9">
                            <article class="entry">
                                <div class="entry-body">
                                    <h2 class="entry-title">
                                        <a>Thank You.</a>
                                    </h2><!-- End .entry-title -->
                                    <div class="entry-content">
                                        <p> Your order has been placed successfully. </p>
                                        <p> Go to <a class="go_to_my_orders_a_tag" href="my_orders.php">My Orders</a> to view your orders.</p>
                                    </div><!-- End .entry-content -->
                                </div><!-- End .entry-body -->
                            </article><!-- End .entry -->
                		</div><!-- End .col-lg-9 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
        </main><!-- End .main -->

<?php 
require('footer.php'); 
?>