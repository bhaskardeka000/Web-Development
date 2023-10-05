<?php 
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Transaction Failed</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="payment_fail.php">Transaction Failed</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

          
                <div class="container">
                	<div class="row">
                		<div class="col-lg-9">
                            <article class="entry">
                                <div class="entry-body">
                                    <h2 class="entry-title">
                                        <a>Transaction Failed.</a>
                                    </h2><!-- End .entry-title -->
                                    <div class="entry-content">
                                        <p> Please try again. </p>
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