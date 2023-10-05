<?php 
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

$price_low_to_high_selected = '';
$price_high_to_low_selected = '';
$new_selected = '';
$old_selected = '';
$sort_order = '';

if(isset($_GET['sort'])){
	$sort = mysqli_real_escape_string($con, $_GET['sort']);
	if($sort=='price_low_to_high'){
		$sort_order=" order by products.price asc";
		$price_low_to_high_selected = "selected";
	}
	if($sort=='price_high_to_low'){
		$sort_order=" order by products.price desc";
		$price_high_to_low_selected = "selected";
	}
	if($sort=='new'){
		$sort_order=" order by products.id desc";
		$new_selected = "selected";
	}
	if($sort=='old'){
		$sort_order=" order by products.id asc";
		$old_selected = "selected";
	}
}
?>

<head>
<style>
.toolbox .select-custom::after {
    left: 14.5rem;
}

.toolbox .select-custom .form-control {
    min-width: 165px;
}
    </style>
</head>
      <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">All Products</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="all_products.php">All Products</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="toolbox">

                				<div class="toolbox-right">
                					<div class="toolbox-sort">
                						<label for="sortby">SORT BY:</label>
                						<div class="select-custom">
											<select name="sortby" id="sort_product_id" onchange="sort_all_products_drop('<?php echo SITE_PATH_SORTING ?>')" class="form-control" style="color: black;">
												<option>Default Sorting</option>
												<option value="price_low_to_high" <?php echo $price_low_to_high_selected ?>>Price -- Low to High</option>
												<option value="price_high_to_low" <?php echo $price_high_to_low_selected ?>>Price -- High to Low</option>
												<option value="new" <?php echo $new_selected ?>>Newest First</option>
												<option value="old" <?php echo $old_selected ?>>Oldest First</option>
											</select>
										</div>
                					</div><!-- End .toolbox-sort -->
                				</div><!-- End .toolbox-right -->
                			</div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <div class="row justify-content-center">
                                    <?php
                                    $res = mysqli_query($con, "select products.* from products join categories on products.categories_id = categories.id where categories.status = 1 and products.status = 1 $sort_order");
                                    while($all_products = mysqli_fetch_assoc($res)){
                                    ?>
                                    <div class="col-6 col-md-4 col-lg-3 col-xl-3 products_col">
                                        <div class="product product-7 text-center" onclick="location.href='products.php?id=<?php echo encrypt_id($all_products['id']) ?>'" style="cursor: pointer;">
                                            <figure class="product-media figure_all_products_page">
                                                <a href="products.php?id=<?php echo encrypt_id($all_products['id']) ?>">
                                                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$all_products['image'] ?>" alt="Product image" class="product-image">
                                                </a>
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <h3 class="product-title" title="<?php echo $all_products['name']?>"><a href="products.php?id=<?php echo encrypt_id($all_products['id']) ?>"> <?php echo mb_strimwidth($all_products['name'], 0, 27, "...") ?> </a></h3><!-- End .product-title -->
                                                <div class="product-price">
                                                     ₹<?php echo $all_products['price'] ?> &nbsp; <del style="color: #878787;"> ₹<?php echo $all_products['mrp'] ?> </del>
                                                </div><!-- End .product-price -->
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                                    <?php } ?>
                                </div><!-- End .row -->
                            </div><!-- End .products -->


                			<!-- <nav aria-label="Page navigation">
							    <ul class="pagination justify-content-center">
							        <li class="page-item disabled">
							            <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
							                <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
							            </a>
							        </li>
							        <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
							        <li class="page-item"><a class="page-link" href="#">2</a></li>
							        <li class="page-item"><a class="page-link" href="#">3</a></li>
							        <li class="page-item-total">of 6</li>
							        <li class="page-item">
							            <a class="page-link page-link-next" href="#" aria-label="Next">
							                Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
							            </a>
							        </li>
							    </ul>
							</nav> -->
                		</div><!-- End .col-lg-9 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

<?php 
require('footer.php'); 
?>       