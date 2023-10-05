<?php 
require('top.php');

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['product_and_my_cart_form'])){
	$my_cart_form_generated_token = bin2hex(random_bytes(16));
	$_SESSION['csrf_token']['product_and_my_cart_form'] = $my_cart_form_generated_token;
	$_SESSION['last_generated_token_time']['product_and_my_cart_form'] = time();
}
else{
	$interval = 60 * 15;
	if(time() -  $_SESSION['last_generated_token_time']['product_and_my_cart_form']>= $interval){
		$my_cart_form_generated_token = bin2hex(random_bytes(16));
		$_SESSION['csrf_token']['product_and_my_cart_form'] = $my_cart_form_generated_token;
		$_SESSION['last_generated_token_time']['product_and_my_cart_form'] = time();
	}
	else{
		$my_cart_form_generated_token = $_SESSION['csrf_token']['product_and_my_cart_form'];
	}
}
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">My Cart</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="cart.php">My Cart</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="cart">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-lg-9">
	                			<table class="table table-cart table-mobile">
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
                                    <?php 
                                        $cart_total = 0;
                                        if(isset($_SESSION['cart'])){
                                        foreach($_SESSION['cart'] as $key=>$val){
                                            $productArr = get_product($con, '', '', $key);
											$id = $productArr[0]['id'];
                                            $pname = $productArr[0]['name'];
                                            $mrp = $productArr[0]['mrp'];
                                            $price = $productArr[0]['price'];
                                            $image = $productArr[0]['image'];
                                            $qty = $val['qty'];
                                            $cart_total = $cart_total + ($price*$qty);
                                    ?>
										<tr>
											<td class="product-col">
												<div class="product cart_product_figure_and_title_div">
													<figure class="product-media cart_product_image_figure">
														<a href="products.php?id=<?php echo encrypt_id($id) ?>">
															<img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image ?>" alt="Product image">
														</a>
													</figure>

													<h3 class="product-title">
														<a href="products.php?id=<?php echo encrypt_id($id) ?>"> <?php echo $pname ?> </a>
													</h3><!-- End .product-title -->
												</div><!-- End .product -->
											</td>
											<td class="price-col"> <span class="cart_price_span">Price: </span>₹<?php echo $price ?> </td>
											<td class="product-quantity">
                                            <div>
											<span class="cart_qty_span">Qty: </span>
                                            <button class="increment-btn updateQty">&#43;</button>
											<input type="hidden" class="update_product_token" value="<?php echo $my_cart_form_generated_token ?>">
                                            <input type="hidden" class="productId" value="<?php echo encrypt_id($key) ?>" >
                                            <input class="input-qty" type="text" value="<?php echo $qty ?>" disabled style="width: 28%;">
                                            <button class="decrement-btn updateQty">&#45;</button>
                                            </div>  
                                            </td>
											<td class="total-col"> <span class="cart_total_span">Total: </span>₹<?php echo $qty*$price ?> </td>
											<td class="remove-col">
												<input type="hidden" id="add_or_remove_product_token" value="<?php echo $my_cart_form_generated_token ?>">
												<button class="btn-remove" href="javascript:void(0)" onclick="manage_cart('<?php echo encrypt_id($key) ?>', 'remove')"><i class="icon-close"></i></button>
											</td>
										</tr>
                                        <?php } }
										if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
										?>
										<td class="empty_cart_td">Your cart is empty !</td>
										<?php
										}
										?>
									</tbody>
								</table><!-- End .table table-wishlist -->
	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td class="cart_subtotal_with_ruppee_symbol"> ₹<?php echo $cart_total ?> </td>
	                						</tr><!-- End .summary-subtotal -->

	                						<tr class="summary-total">
	                							<td>Total:</td>
	                							<td class="cart_total_with_ruppee_symbol"> ₹<?php echo $cart_total ?> </td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                				<a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block proceed_to_checkout_btn">PROCEED TO CHECKOUT</a>
	                			</div><!-- End .summary -->

		            			<a href="index.php" class="btn btn-outline-dark-2 btn-block mb-3 continue_shopping_btn"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

<?php 
require('footer.php');
?>