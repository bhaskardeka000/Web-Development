<?php
require('top.php');
// require('track_ip_address.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>



<main class="main">
            <div class="intro-slider-container">
                <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>
                    <div class="intro-slide" style="background-image: url('assets/images/demos/demo-2/slider/slide-1.jpg');">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle">Bedroom Furniture</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">Find Comfort <br>That Suits You.</h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-primary">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .container intro-content -->
                    </div><!-- End .intro-slide -->

                    <!-- <div class="intro-slide" style="background-image: url('assets/images/demos/demo-2/slider/slide-2.jpg');">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle">Deals and Promotions</h3> -->
                            <!-- End .h3 intro-subtitle -->
                            <!-- <h1 class="intro-title">Ypperlig <br>Coffee Table <br><span class="text-primary"><sup>$</sup>49,99</span></h1> -->
                            <!-- End .intro-title -->

                            <!-- <a href="category.html" class="btn btn-primary">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a> -->
                        <!-- </div> -->
                        <!-- End .container intro-content -->
                    <!-- </div> -->
                    <!-- End .intro-slide -->

                    <div class="intro-slide" style="background-image: url('assets/images/demos/demo-2/slider/slide-3.jpg');">
                        <div class="container intro-content">
                            <h3 class="intro-subtitle">Living Room</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">
                                Make Your Living Room <br>Work For You.<br>
                                <span class="text-primary">
                                    <sup class="text-white font-weight-light">from</sup><sup>$</sup>9,99
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-primary">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .container intro-content -->
                    </div><!-- End .intro-slide -->
                </div><!-- End .owl-carousel owl-simple -->

                <!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->


     

     

            <div class="mb-6"></div><!-- End .mb-6 -->

            <div class="container">
                <div class="heading heading-center mb-3">
                    <h2 class="title title_underline">Newly <span>Added...</span></h2><!-- End .title -->
                </div><!-- End .heading -->

                <div class="tab-content tab-content-carousel">
                <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel" aria-labelledby="trendy-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "autoplay": true,
                                "autoplayTimeout": 4000,
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "rewind": true,
                                "responsive": {
                                    "0": {
                                        "items":1
                                    },
                                    "300": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":3
                                    },
                                    "600": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":5
                                    },
                                    "1200": {
                                        "items":5,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>           
                            <?php
                            $get_product = get_product($con, 8);
                            foreach($get_product as $list){
                            ?>
                               
                                    <div class="product product-11 text-center" onclick="location.href='products.php?id=<?php echo encrypt_id($list['id']) ?>'" style="cursor: pointer;">
                                        <figure class="product-media figure_homepage">
                                            <a href="products.php?id=<?php echo encrypt_id($list['id']) ?>">
                                               <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image'] ?>" alt="product images" class="product-image">
                                            </a>
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <h3 class="product-title" title="<?php echo $list['name'] ?>"><a href="products.php?id=<?php echo encrypt_id($list['id']) ?>"> <?php echo mb_strimwidth($list['name'], 0, 21, "...") ?> </a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                ₹<?php echo $list['price'] ?> &nbsp; <del style="color: #878787;">₹<?php echo $list['mrp'] ?></del>
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                               
                                <?php } ?>
                        </div>
                    
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .container -->

            <div class="container">
                <hr class="mt-1 mb-6">
            </div><!-- End .container -->

                        <div class="container recommendation_container">
                <div class="heading heading-center mb-3">
                    <h2 class="title title_underline">You may <span>like this...</span></h2><!-- End .title -->
                </div><!-- End .heading -->

                <div class="tab-content tab-content-carousel">
                <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel" aria-labelledby="trendy-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "autoplay": true,
                                "autoplayTimeout": 5000,
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "rewind": true,
                                "responsive": {
                                    "0": {
                                        "items":1
                                    },
                                    "300": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":3
                                    },
                                    "600": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":5
                                    },
                                    "1200": {
                                        "items":5,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>           
                            <?php
                            $get_recommended_products = mysqli_query($con, "select * from products where status = 1");
                            while($list = mysqli_fetch_assoc($get_recommended_products)){
                                $productSoldQtyByProductId = productSoldQtyByProductId($con, $list['id']);
                                if($productSoldQtyByProductId<10){
                            ?>
                               
                                    <div class="product product-11 text-center" onclick="location.href='products.php?id=<?php echo encrypt_id($list['id']) ?>'" style="cursor: pointer;">
                                        <figure class="product-media figure_homepage">
                                            <a href="products.php?id=<?php echo encrypt_id($list['id']) ?>">
                                               <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image'] ?>" alt="product images" class="product-image">
                                            </a>
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <h3 class="product-title" title="<?php echo $list['name']?>"><a href="products.php?id=<?php echo encrypt_id($list['id']) ?>"> <?php echo mb_strimwidth($list['name'], 0, 21, "...") ?> </a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                ₹<?php echo $list['price'] ?> &nbsp; <del style="color: #878787;">₹<?php echo $list['mrp'] ?></del>
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                               
                                <?php } } ?>
                        </div>
                    
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .container -->
            <div class="container">
                <hr class="mt-1 mb-6 before_our_services_main_div_hr">
            </div><!-- End .container -->
            
            <div class="icon-boxes-container mt-2 mb-2 bg-transparent our_services_main_div">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                <i class='fas fa-truck'></i>
                                </span>
                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">Doorstep delivery</h3><!-- End .icon-box-title -->
                                    <p>of all our products</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                <i class="fa fa-money-bill"></i>
                                </span>

                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">COD payment</h3><!-- End .icon-box-title -->
                                    <p>option available</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                                </span>

                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">Responsive website</h3><!-- End .icon-box-title -->
                                    <p>for all platforms</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                <i class="fa fa-life-ring" aria-hidden="true"></i>
                                </span>

                                <div class="icon-box-content">
                                    <h3 class="icon-box-title">24/7 help support</h3><!-- End .icon-box-title -->
                                    <p>is available</p>
                                </div><!-- End .icon-box-content -->
                            </div><!-- End .icon-box -->
                        </div><!-- End .col-sm-6 col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div>
         
        </main><!-- End .main -->




<?php 
require('footer.php'); 
?>