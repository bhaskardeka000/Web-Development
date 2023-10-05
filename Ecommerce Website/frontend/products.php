<?php
ob_start();
require('top.php');

$product_id = get_safe_value($con, $_GET['id']);
$product_id = decrypt_id($product_id);

$check_p_id = mysqli_query($con, "select * from products where id = '$product_id' ");
if(mysqli_num_rows($check_p_id)<1 || strpos($product_id, ".") !== false || is_numeric($product_id) === false){
?>
<script>
window.location.href="index.php";
</script>
<?php
die();
}
$get_product = get_product($con, '', '', $product_id);

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['product_and_my_cart_form'])){
	$product_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['product_and_my_cart_form'] = $product_form_generated_token;
	$_SESSION['last_generated_token_time']['product_and_my_cart_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['product_and_my_cart_form']>= $interval){
		$product_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['product_and_my_cart_form'] = $product_form_generated_token;
		$_SESSION['last_generated_token_time']['product_and_my_cart_form'] = time();
	}
	else{
		$product_form_generated_token = $_SESSION['csrf_token']['product_and_my_cart_form'];
	}
}
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title"><?php echo $get_product['0']['categories'] ?></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="categories.php?id=<?php echo encrypt_id($get_product['0']['categories_id']) ?>"><?php echo $get_product['0']['categories']?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="products.php?id=<?php echo encrypt_id($get_product['0']['id']) ?>"><?php echo $get_product['0']['name']?></a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content products_page_content_div">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-12 col-xl-4 col-md-6 col-sm-6">
                                <div class="product-gallery product-gallery-vertical product_main_image">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>" alt="Product image" class="product_img_src">
                                     <!-- End .product-main-image -->
                                   
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-12 col-xl-8 col-md-6 col-sm-6">
                                <div class="product-details">
                                    <h1 class="product-title"> <?php echo $get_product['0']['name']?> </h1><!-- End .product-title -->
                                    <div class="product-price">
                                        ₹<?php echo $get_product['0']['price']?> &nbsp; <del style="color: #878787;">₹<?php echo $get_product['0']['mrp']?></del>
                                    </div><!-- End .product-price -->

                                    <div class="product-content">
                                        <p> <?php echo $get_product['0']['short_desc']?> </p>
                                    </div><!-- End .product-content -->

                                    <?php
                                    $productSoldQtyByProductId = productSoldQtyByProductId($con, $get_product['0']['id']);

                                    $qty_left = $get_product['0']['qty'] - $productSoldQtyByProductId;
                                    $_SESSION['qty_left'] = $qty_left;
                                    $cart_show = "yes";
                                    if($get_product['0']['qty']>$productSoldQtyByProductId){
                                        $stock = "In Stock";
                                    }
                                    else{
                                        $stock = "Out Of Stock";
                                        $cart_show = "";
                                    }
                                    ?>

                                    <div class="details-filter-row details-row-size">
                                        <p class="stock_availability_p_tag">Availability: <span><?php echo $stock ?></span> </p>
                                    </div><!-- End .details-filter-row -->

                                    <?php
                                    if($cart_show!=''){
                                    ?>

                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Qty:</label>
                                        <div class="product-quantity" style="display: flex;">
                                        <button class="increment-btn-1" onclick="increment()">&#43;</button>
                                        <input class="input-qty" type="number" id="qty" value="1" min="1" max="<?php echo $qty_left ?>" disabled>
                                        <button class="decrement-btn-1" onclick="decrement()">&#45;</button>
                                        </div>
                                    </div><!-- End .details-filter-row -->
                                    
                                    <?php } ?>

                                    <?php
                                    if($cart_show!=''){
                                    ?>
                                    
                                    <div class="product-details-action">
                                        <input type="hidden" id="add_or_remove_product_token" value="<?php echo $product_form_generated_token ?>">
                                        <a href="javascript:void(0)" class="btn-product btn-cart add_to_cart_btn" onclick="manage_cart('<?php echo encrypt_id($get_product['0']['id']) ?>', 'add')"><span>add to cart</span></a>
                                    </div><!-- End .product-details-action -->
                                    
                                    <?php } ?>
                                    
                                    <div class="product-details-footer">
                                        <div class="product-cat products_category">
                                            <span>Category:</span>
                                            <a class="products_category_a_tag" href="categories.php?id=<?php echo encrypt_id($get_product['0']['categories_id']) ?>"> <?php echo $get_product['0']['categories']?> </a>
                                        </div><!-- End .product-cat -->
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    <h3>Product Information:</h3>
                                    <p> <?php echo $get_product['0']['description']?> </p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-details-tab -->

                


                </div><!-- End .container -->
            </div><!-- End .page-content -->

            <?php
            // unset($_COOKIE['recently_viewed']);
              if(isset($_COOKIE['recently_viewed'])){
                $arr_recently_viewed = unserialize($_COOKIE['recently_viewed']);
                $count_recently_viewed = count($arr_recently_viewed);
                $count_start_value_of_recently_viewed = $count_recently_viewed-8;
                if($count_recently_viewed>8){
                    $arr_recently_viewed = array_slice($arr_recently_viewed, $count_start_value_of_recently_viewed, 8);
                }
                // pr($arr_recently_viewed);
                $recently_viewed_id = implode(",", $arr_recently_viewed);
                $recently_viewed_res = mysqli_query($con, "select * from products where id IN ($recently_viewed_id) order by field(id, $recently_viewed_id) desc");
            ?>
            <div class="container">
                <div class="heading heading-center mb-3 recently_viewed_heading_div">
                    <h2 class="title title_underline title_recently_viewed">Recently Viewed</h2><!-- End .title -->
                </div><!-- End .heading -->

                <div class="tab-content tab-content-carousel">
                <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel" aria-labelledby="trendy-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
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
                            while($list = mysqli_fetch_assoc($recently_viewed_res)){
                            ?>
                               
                                    <div class="product product-11 text-center" onclick="location.href='products.php?id=<?php echo encrypt_id($list['id']) ?>'" style="cursor: pointer;">
                                        <figure class="product-media figure_recently_viewed">
                                            <a href="products.php?id=<?php echo encrypt_id($list['id']) ?>">
                                               <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images" class="product-image">
                                            </a>
                                        </figure><!-- End .product-media -->

                                        <div class="product-body recently_viewed_product_body">
                                            <h3 class="product-title" title="<?php echo $list['name']?>"><a href="products.php?id=<?php echo encrypt_id($list['id']) ?>"> <?php echo mb_strimwidth($list['name'], 0, 21, "...")?> </a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                ₹<?php echo $list['price']?> &nbsp; <del style="color: #878787;">₹<?php echo $list['mrp']?></del>
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                               
                                <?php } ?>
                        </div>
                    
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .container -->
            <?php
            $arrRec = unserialize($_COOKIE['recently_viewed']);
            if(($key = array_search($product_id, $arrRec))!==false){
                unset($arrRec[$key]);
            }
            $arrRec[] = $product_id;
            setcookie('recently_viewed', serialize($arrRec), time()+60*60*24*365);
        } 
         else{
            $arrRec[] = $product_id;
            setcookie('recently_viewed', serialize($arrRec), time()+60*60*24*365);
        }
            ?>
        </main><!-- End .main -->

<?php 
require('footer.php');
ob_flush();
?>
