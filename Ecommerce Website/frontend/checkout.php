<?php
ob_start();
require('top.php');
$msg_error="";
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if(!isset($_SESSION['USER_LOGIN'])){
?>
<script>
window.location.href="login.php";
</script>
<?php
die();
}

else if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){   
?>
<script>
window.location.href="cart.php";
</script>
<?php
die();
}

$cart_total = 0;
foreach($_SESSION['cart'] as $key=>$val){
    $productArr = get_product($con, '', '', $key);
    $price = $productArr[0]['price'];
    $qty = $val['qty'];
    $cart_total = $cart_total + ($price*$qty);
}

if(isset($_POST['submit'])){
    $pincode = get_safe_value($con, $_POST['pincode']);
    $state = get_safe_value($con, $_POST['state']);
    $house_no = get_safe_value($con, $_POST['house_no']);
    $street_address = get_safe_value($con, $_POST['street_address']);
    $city = get_safe_value($con, $_POST['city']);
    if(isset($_POST['payment_type'])){
        $payment_type = get_safe_value($con, $_POST['payment_type']);
    }
    else if(!isset($_POST['payment_type'])){
        $payment_type = "";
    }
    $user_id = $_SESSION['USER_ID'];
    $total_price = $cart_total;

    $house_no = preg_replace('/\s+/', ' ', $house_no);
    $street_address = preg_replace('/\s+/', ' ', $street_address);
    $city = preg_replace('/\s+/', ' ', $city);
    $state = strtoupper($state);
    $check_pincode_result = mysqli_query($con, "select StateName from pincodes where pincode='$pincode' limit 1");
    $state_name = mysqli_fetch_assoc($check_pincode_result);
    // $internet_connection = @fsockopen("www.google.com", 80);

    if(!isset($_POST['checkout_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['checkout_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['checkout_form']) || ($_POST['checkout_form_token'] !== $_SESSION['csrf_token']['checkout_form'])){
        ?>
        <script>
        alert("Error: Multiple tabs are open/token expired/invalid token");
        window.location.href = "index.php";
        </script>
        <?php
        die();
    }
    else if($pincode=='' || $state=='' || $house_no=='' || $street_address=='' || $city=='' || $payment_type==''){
        $_SESSION['Message'] = 'Please fillup all the required details.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if(mysqli_num_rows($check_pincode_result)<1){
        $_SESSION['Message'] = 'Invalid pincode. Please click on check pincode to check the pincode and get the state name.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if(mysqli_num_rows($check_pincode_result)>0 && trim($state_name['StateName'])!=$state){
        $_SESSION['Message'] = 'State name not matching with pincode. Please click on check pincode to check pincode and get the state name.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if(strlen($house_no)<1){
        $_SESSION['Message'] = 'Flat / House No / Apartment / Block details is insufficient to attempt delivery.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if(strlen($street_address)<=5){
        $_SESSION['Message'] = 'Street Address details is insufficient to attempt delivery.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if(strlen($city)<=2){
        $_SESSION['Message'] = 'City / District / Town details is insufficient to attempt delivery.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if($payment_type!='cod' && $payment_type!='payu'){
        $_SESSION['Message'] = 'Please select valid payment mode.';
        ?>
        <script>
        window.location.href = window.location.href;
        </script>
        <?php
        die();
    }
    else if(count($_SESSION['cart'])==0){
        ?>
        <script>
        window.location.href="cart.php";
        </script>
        <?php
        die();
    }
    else{
    $payment_status = 'pending';
    if($payment_type == 'cod'){
    $payment_status = "success";
    }
    $order_status = "1";
    $added_on = date('Y-m-d h:i:s');
    // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    mysqli_query($con, "insert into orders(user_id, pincode, state, house_no, street_address, city, payment_type, total_price, payment_status, order_status, added_on) values('$user_id', '$pincode', '$state', '$house_no', '$street_address', '$city', '$payment_type', '$total_price', '$payment_status', '$order_status', '$added_on')");
    
    $order_id = mysqli_insert_id($con);
    mysqli_query($con, "insert into transactions(order_id) values('$order_id')");
    $txnid = mysqli_insert_id($con);
    mysqli_query($con, "insert into invoices(order_id) values('$order_id')");
    $cart_total = 0;
    foreach($_SESSION['cart'] as $key=>$val){
        $productArr = get_product($con, '', '', $key);
        $name = $productArr[0]['name'];
        $image = $productArr[0]['image'];
        $price = $productArr[0]['price'];
        $qty = $val['qty'];
    $added_on = date('Y-m-d h:i:s');
    
        mysqli_query($con, "insert into order_details(order_id, product_id, name, image, qty, price, added_on) values('$order_id', '$key', '$name', '$image', '$qty', '$price', '$added_on')");
        $source = "../media/product/$image";
        $destination = "../media/ordered_items/$image";
        copy($source, $destination);
    }
    unset($_SESSION['cart']);

    if($payment_type == 'payu'){
   
        $userArr = mysqli_fetch_assoc(mysqli_query($con, "select * from users where id = '$user_id'"));
        $key="iG8Edz";
        $salt="MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC/K0Zbf60KlwxiMrQ2uxfxpOYX4t5fDe8HQald8zmu30NgIs13/OpJNz8gWl9h7YFOJW1XbokAA3W0IvbhsPuvC+eGbpWJC0q0ExRqDIM2BxpRGlsfmZT7oIfgakwaNd5BljuNrAYkcIe22D83zQC5w98Gqmv0TvHBgd7kKDEMqvvHm46gOzEvjuRN9/zc1i8zuFJk00FaMbcrRlyZMCGblaXbozgpcEvAvhDE4etWBfJ/0VZuXjOVmD90bf+DN3wGtShcs/Dm+ZzpYgSYW2wLhZFX2vNQaeAjmTbU3KsD8kwf+wfiA65axCzSARtKjrOfAoLmoIagRPtYL7RODaHDAgMBAAECggEBALoL/qQrxJeK21VyLSsauDnHFttmQq5VnCv+vjsd7CSBSkv0cuz0anqo1rnA2hUvFOmdySUPASvPMi0G3ihVmwwH1OJjGwrNv30zGGoBFW1uSjFmKgq96F1fJP3F1Zyokk5YTEsbgLrT/XB4UkYXMD6aHqKZFwkkD2oY33hCmUHOMtXvQqNNlF8hBCayXJ2PQMlZvsMwIFIISJhcO929AsfNRyRiZkSYhTXuVdjzK9fdkALvJe3YJPd/qxm0GDMNwL1t/75NMLXxKYd23i9BdYGHVpaouXD/GnddQw5lgNiyTJ0eGI6vTb/95ONIpXwwv0T9N6JN7+uFIHcq81N6nLECgYEA5pawJ89VtHvsfae14jYM6ry+OwOdyWTBF0nkYVwFXgzEWLIxYV/SSfarIrGuE6WUKaG0/rFYaBQViA+s8G4FZlE1VsIp6tcUvHz1DeoS24V8dZjf8jwMfy9ZgTK8urbLxWSJ33FH8GreyeDsxC0o4GNkbdpiqCeCXb54brDG/NkCgYEA1Dx9obgkkoFmo6zoK854dBnxx0cj3cdNvBD3XBIFF8lvFebzc7FHXgb0wnbyn8s37Vm4lwXgKbWtt5WxXJE9hElg3DHYXRt/jlopW4++j69MIh2mtA6ecYp9+AelWq9B824z8BKGB0VWfGmDb/fx1ZofeXgoGwyXAq5gfzzh4fsCgYB7pE8+eXFGPrC3S+c+LadNcvk54Z2IsKrM1wVLozEJliTuPlY2FVBH8qkfCFEEHePNUvUfIG78F9DXzTf5D7V7gI3uQFyDnOJ0kzg/RsTnyrLKx7dFRyeYRwZiPZdvMrce1+MJ2c8uPc/KRf4Ozvw9HW5rbQ87hTvlEk23ZLi+OQKBgA9jk3h2cbBt0ZNspikG/5TrjKx2bBNYsDpCwKzcYaIn6PYdmOl6oUIgHv86wLz1b0i2iLvqoSZlFgOJxyJ/JYbCC1PsCVQ2+jjIMNeCxL6GZ27R15SWusZg1GF3rHW234FXLEzsCuvcCzlaLT2hLNfgJQgZvk63yvtWyYhwUbChAoGBAMabzpYHKno7v78WxWddV+YvnPeMAkrM8VgMkDLO8z0FfPswgOWpyBOb1eNR3lYy0fAguz1IH4ARkzG7i9v8XUiG0uOYLirpO0ZxQFOjko3wn+eq+T0FJkEiR7GnzCbxLXhbUOH4EMXNKHsbp5oltRLEs+MKwnWy7Ga2c47vTC85";
        $action = 'https://test.payu.in/_payment';
        $amount = $total_price;
        $productinfo = "Payment";
        $firstname = $userArr['name'];
        $email = $userArr['email'];
        $udf5 = "PayUBiz_PHP7_Kit";
        $mobile = $userArr['mobile'];
        $pincode1 = $pincode;
        $state1 = $state;
        $street_address1 = $house_no;
        $street_address2 = $street_address;
        $city1 = $city;
        $country1 = "India";
        $hash=hash('sha512', $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'||||||'.$salt);

        $html = '<form action="'.$action.'" id="payment_form" method="post">
<input type="hidden" id="udf5" name="udf5" value="PayUBiz_PHP7_Kit" />	
<input type="hidden" id="surl" name="surl" value="'.PAYMENT_GATEWAY_PAYMENT_CATCH.'" />
<input type="hidden" id="furl" name="furl" value="'.PAYMENT_GATEWAY_PAYMENT_CATCH.'" />
<input type="hidden" id="key" name="key" value="'.$key.'" />				
<input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID" value="'.$txnid.'" />
<input type="hidden" id="amount" name="amount" placeholder="Amount" value="'.$amount.'" />    
<input type="hidden" id="productinfo" name="productinfo" placeholder="Product Info" value="'.$productinfo.'" />
<input type="hidden" id="firstname" name="firstname" placeholder="First Name" value="'.$firstname.'" />
<input type="hidden" id="Zipcode" name="Zipcode" placeholder="Zip Code" value="'.$pincode1.'" />
<input type="hidden" id="email" name="email" placeholder="Email ID" value="'.$email.'" /></span>
<input type="hidden" id="phone" name="phone" placeholder="Mobile/Cell Number" value="'.$mobile.'" />
<input type="hidden" id="address1" name="address1" placeholder="Address1" value="'.$street_address1.'" />
<input type="hidden" id="address2" name="address2" placeholder="Address2" value="'.$street_address2.'" />	
<input type="hidden" id="city" name="city" placeholder="City" value="'.$city1.'" />
<input type="hidden" id="state" name="state" value="'.$state1.'" />
<input type="hidden" id="country" name="country" value="'.$country1.'" />
<input type="hidden" id="hash" name="hash" value="'.$hash.'" />
<input type="submit" style="display:none;"/>
</form>';
echo $html;
echo '<script type="text/javascript">document.getElementById("payment_form").submit();</script>';
}
else{
    email_invoice($con, $order_id, $user_id);
    unset($_SESSION['last_generated_token_time']['product_and_my_cart_form']);
    unset($_SESSION['csrf_token']['product_and_my_cart_form']);
    unset($_SESSION['last_generated_token_time']['checkout_form']);
    unset($_SESSION['csrf_token']['checkout_form']);
    session_regenerate_id(true);
?>
<script>
window.location.href="payment_complete.php";
</script>
<?php
die();
}
}
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['checkout_form'])){
    $checkout_form_generated_token = bin2hex(random_bytes(16));
    $_SESSION['csrf_token']['checkout_form'] = $checkout_form_generated_token;
    $_SESSION['last_generated_token_time']['checkout_form'] = time();
}
else{
    $interval = 60 * 15;
    if(time() -  $_SESSION['last_generated_token_time']['checkout_form']>= $interval){
        $checkout_form_generated_token = bin2hex(random_bytes(16));
        $_SESSION['csrf_token']['checkout_form'] = $checkout_form_generated_token;
        $_SESSION['last_generated_token_time']['checkout_form'] = time();
    }
    else{
        $checkout_form_generated_token = $_SESSION['csrf_token']['checkout_form'];
    }
}
?>

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Checkout</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="checkout.php">Checkout</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
            			<form method="post">
                            <input type="hidden" name="checkout_form_token" value="<?php echo $checkout_form_generated_token ?>">
		                	<div class="row">
		                		<div class="col-lg-9">
                                    <div class="summary">
		                				<h3 class="summary-title" style="padding-bottom: 10px; margin-bottom: 5px;">Note for international shipping:</h3><!-- End .summary-title -->
										<p>We also ship our Scotch Club International products internationally. If you want us to deliver products outside India, then send us a message <a class="message_here_a_tag" href="contact_us.php">here</a>.</p>
		                			</div>
		                			<h2 class="checkout-title checkout_title_of_billing_details">Billing Details:</h2><!-- End .checkout-title -->
                                    <?php
                                    if(isset($_SESSION['Message'])){
                                    ?>
                                    <div class="alert alert-danger checkout_field_error" role="alert">
                                        <?php echo $_SESSION['Message'] ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['Message']);
                                    }
                                    ?>
                                        <div class="row">
                                            <div class="col-sm-6 input_pincode_div">
		                						<label>Pincode *</label>
		                						<input type="number" class="form-control checkout_form_details checkout_form_details_input_pincode" id="pincode" name="pincode" autocomplete="turn_off" required>
                                                <p class="field_error" id="check_pincode_error"></p>
                                                <a role="button" onclick="check_pincode()" class="check_pincode_a_tag" id="check_pincode_text">Check pincode</a>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>State *</label>
		                						<input type="text" class="form-control checkout_form_details checkout_form_details_input_state" id="state" name="state" autocomplete="turn_off" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

                                        <label>Flat / House No / Apartment / Block *</label>
	            						<input type="text" class="form-control checkout_form_details" name="house_no" autocomplete="off" required>

	            						<label>Street Address *</label>
	            						<input type="text" class="form-control checkout_form_details" name="street_address" autocomplete="off" required>

                                        <div class="row">
		                					<div class="col-sm-6">
		                						<label>City / District / Town *</label>
		                						<input type="text" class="form-control checkout_form_details" name="city" autocomplete="turn_off" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->
                                        
		                		</div><!-- End .col-lg-9 -->
		                		<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                					<thead>
		                						<tr>
		                							<th>Product</th>
		                							<th>Total</th>
		                						</tr>
		                					</thead>

		                					<tbody>
                                                <?php
                                                $cart_total = 0;
                                                foreach($_SESSION['cart'] as $key=>$val){
                                                    $productArr = get_product($con, '', '', $key);
                                                    $pname = $productArr[0]['name'];
                                                    $price = $productArr[0]['price'];
                                                    $qty = $val['qty'];
                                                    $cart_total = $cart_total + ($price*$qty);
                                                ?>
		                						<tr>
		                							<td><a class="checkout_each_product_name"> <?php echo $pname?> </a></td>
		                							<td class="checkout_price_with_ruppee_symbol checkout_each_product_price"> ₹<?php echo $qty*$price?> </td>
		                						</tr>
                                                <?php } ?>
		                						<tr class="summary-subtotal">
		                							<td>Subtotal:</td>
		                							<td class="checkout_price_with_ruppee_symbol"> ₹<?php echo $cart_total?> </td>
		                						</tr><!-- End .summary-subtotal -->

		                						<tr class="summary-total">
		                							<td>Total:</td>
		                							<td class="checkout_price_with_ruppee_symbol"> ₹<?php echo $cart_total?> </td>
		                						</tr><!-- End .summary-total -->
		                					</tbody>
		                				</table><!-- End .table table-summary -->

		                				<div class="accordion-summary" id="accordion-payment">

										    <div class="card">
										     
                                                    <label class="radio-button">
                                                        <input type="radio" name="payment_type" value="cod" required>
                                                        <span class="label-visible">
                                                          <span class="fake-radiobutton"></span>
                                                          COD(Cash on delivery)
                                                        </span>
                                                    </label>
										    </div><!-- End .card -->
										    <div class="card">
                                                    <label class="radio-button">
                                                        <input type="radio" name="payment_type" value="payu" required>
                                                        <span class="label-visible">
                                                          <span class="fake-radiobutton"></span>
                                                          PAYU
                                                        </span>
                                                    </label>
										    </div><!-- End .card -->
										</div><!-- End .accordion -->

		                				<input type="submit" class="btn btn-outline-primary-2 btn-order btn-block" name="submit" value="Place Order">
                                        </input>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                	</div><!-- End .row -->
            			</form>
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->


<?php
require('footer.php');
?>