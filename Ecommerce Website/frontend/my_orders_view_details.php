<?php
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

$order_id = get_safe_value($con, $_GET['id']);
$order_id = decrypt_id($order_id);
$uid = $_SESSION['USER_ID'];

if(!isset($_SESSION['USER_ID'])){
?>
<script>
window.location.href="login.php";
</script>
<?php
die();
}

if(strpos($order_id,".") !== false || is_numeric($order_id) === false){
?>
<script>
window.location.href="my_orders.php";
</script>
<?php
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['download_invoice_form'])){
  $download_invoice_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['download_invoice_form'] = $download_invoice_form_generated_token;
  $_SESSION['last_generated_token_time']['download_invoice_form'] = time();
}
else{
  $interval = 60 * 15;
  if(time() -  $_SESSION['last_generated_token_time']['download_invoice_form']>= $interval){
    $download_invoice_form_generated_token = bin2hex(random_bytes(16));
    $_SESSION['csrf_token']['download_invoice_form'] = $download_invoice_form_generated_token;
    $_SESSION['last_generated_token_time']['download_invoice_form'] = time();
  }
  else{
    $download_invoice_form_generated_token = $_SESSION['csrf_token']['download_invoice_form'];
  }
}
?>

<head>
<style>
  /* p{
    color: #637381 !important;
    font-size: 15px !important;
  } */

.summary_of_order_details_main_div{
  margin: 0 10%;
  margin-top: 1rem;
  margin-bottom: 7rem;
  border: 1px solid #ddd;
  padding: 40px;
  border-radius: 6px;
}

p{
  font-size: 16px;
  word-break: break-word;
}

table {
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

thead{
  background: #e0e8ff;
  border-bottom: 1px solid #e9ecef;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  padding: .35em;
  border: 1px solid #ddd;
}

table th,
table td {
  /* padding: .625em; */
  text-align: center;
}

table th {
  font-size: 19px;
  padding: 5px;
}

table td{
  padding: 0.75em 1.25em;
  cursor: pointer;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
    background-color: #f8f8f8;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }

  .order_details_extra_space_td{
    display: none;
  }
}

@media screen and (max-width: 992px){
  .order_details, .delivery_details, .contact_details{
    margin-bottom: 2rem;
  }
}

@media screen and (width: 992px){
  .order_details, .delivery_details, .contact_details{
    margin-bottom: 0;
  }
}

.download-invoice-btn{
  color: rgb(133, 0, 75);
    border-color: rgb(133, 0, 75);
    padding-top: 0.55rem;
    padding-bottom: 0.55rem;
    /* font-size: 1.3rem; */
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-weight: 400;
    /* font-size: 1.4rem; */
    line-height: 1.5;
    letter-spacing: -0.01em;
    min-width: 170px;
    border-radius: 0;
    white-space: normal;
    transition: all 0.3s;
    /* color: #85004b; */
    background-color: transparent;
    background-image: none;
    /* border-color: #85004b; */
    box-shadow: none;
    width: 75%;
    border: 1px solid;
    font-size: 14px;
    text-decoration: none;
    margin-top: 1rem;
}

.download-invoice-btn:hover, .download-invoice-btn:focus, .download-invoice-btn:active{
  background-color: rgb(133, 0, 75);
  color: white;
}
    </style>
</head>

          <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Order Details</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="my_orders_view_details.php?id=<?php echo encrypt_id($order_id) ?>">Order Details</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

    <div class="summary_of_order_details_main_div">

        <?php 
        $res = mysqli_query($con, "select orders.id as order_id, orders.pincode as order_pincode, orders.state as order_state, orders.house_no as order_house_no, orders.street_address as order_street_address, orders.city as order_city, orders.payment_type as order_payment_type, DATE_FORMAT(orders.added_on,'%Y-%m-%d') as order_date, orders.payment_status as order_payment_status, order_status.name as order_status_str, users.name as user_name, users.email as user_email, users.mobile as user_mobile from orders join users on orders.user_id = users.id join order_status on orders.order_status = order_status.id where orders.id = '$order_id' and users.id = '$uid' ");
        if(mysqli_num_rows($res)>0){
        $info = mysqli_fetch_assoc($res);
        ?>
      <div class="row">

        <?php 
        $check_payment_status = mysqli_query($con, "select * from orders where id = '$order_id' and payment_status = 'success' ");
        if(mysqli_num_rows($check_payment_status)>0){
          $div_col_1 = 3;
          $div_col_2 = 3;
          $div_col_3 = 3;
        }
        else{
          $div_col_1 = 4;
          $div_col_2 = 4;
          $div_col_3 = 4;
        }
        ?>

        <div class="col-lg-<?php echo $div_col_1 ?> order_details">

          <!-- <div class="col-lg-4" style="padding: 0 35px;"> -->

          <p style="font-weight: 500;">Order ID: <?php echo $info['order_id'] ?></p>

          <p>Order Date: <?php echo $info['order_date'] ?></p>
            
          <p>Payment Mode: <span style="text-transform: uppercase;"><?php echo $info['order_payment_type'] ?></span></p>
          
          <p>Payment Status: <span style="text-transform: capitalize;">
          
          <?php
          if($info['order_payment_status'] =='pending'){
            echo "Pending";
          }
          else if($info['order_payment_status'] =='failure'){
            echo "Failed";
          }
          else if($info['order_payment_status'] =='success'){
            echo "Complete";
          }
          
          ?></span></p>

          <p>Order Status: <?php echo $info['order_status_str'] ?></p>
        
        </div>

        <div class="col-lg-<?php echo $div_col_2 ?> delivery_details">

          <p style="font-weight: 500;">Delivery Address:</p>

          <p class="delivery_address_user_name"><?php echo $info['user_name'] ?></p>

          <p class="delivery_address_full_address"><?php echo $info['order_house_no'] ?>, <?php echo $info['order_street_address'] ?>, <?php echo $info['order_city'] ?>, <?php echo $info['order_state'] ?>,</p>

          <p>Pincode: <?php echo $info['order_pincode'] ?></p>

        </div>

        <div class="col-lg-<?php echo $div_col_3 ?> contact_details">
          
          <p style="font-weight: 500;">Contact Details:</p>

          <p>Email: <?php echo $info['user_email'] ?></p>
          
          <p>Mobile No: <?php echo $info['user_mobile'] ?></p>

        </div>

        <?php
        if(mysqli_num_rows($check_payment_status)>0){
        ?>
          <div class="col-lg-3 contact_details">
            
            <p style="font-weight: 500;">Invoice:</p>
  
            <form id="download_invoice" action="download_invoice.php" method="post">
            <input type="hidden" name="download_invoice_form_token" value="<?php echo $download_invoice_form_generated_token ?>">
            <input type="hidden" name="order_id" value="<?php echo encrypt_id($info['order_id']) ?>">
            </form>
            <button class="download-invoice-btn" onclick="document.forms['download_invoice'].submit()">Download Invoice</button>
  
          </div>
        <?php
        }
        ?>

        
      </div>


      <div class="table-responsive-md" style="margin-top: 4%;">
      
        <?php
        $res1 = mysqli_query($con, "select distinct(order_details.id), order_details.* from order_details, orders where order_details.order_id = '$order_id' and orders.user_id = '$uid' ");
        if(mysqli_num_rows($res1)>0){
        ?>

        <table>
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Subtotal</th>
            </tr>
          </thead>
          <tbody>

              <?php
              $total_price = 0;
              while($row = mysqli_fetch_assoc($res1)){
              $total_price = $total_price + ($row['qty'] * $row['price']);
              ?>

            <tr>
              <td data-label="Product">
              <img src="<?php echo ORDERED_ITEMS_IMAGE_SITE_PATH.$row['image'] ?>" alt="Product Image" style="width: 45px; height: 45px; display: initial;">
                <span style="vertical-align:middle; word-wrap: break-word;"> <?php echo $row['name'] ?> </span>
              </td>
              <td data-label="Price"> ₹<?php echo $row['price'] ?> </td>
              <td data-label="Quantity"> <?php echo $row['qty'] ?> </td>
              <td data-label="Subtotal"> ₹<?php echo $row['qty'] * $row['price'] ?> </td>
            </tr>
              <?php } ?>
            <tr class="order_details_total_price_tr">
              <td colspan="2" class="order_details_extra_space_td"></td>
              <td colspan="1" class="order_details_extra_space_td"></td>
              <td class="order_details_total_price_td">GRAND TOTAL: ₹<?php echo $total_price ?></td>
            </tr>
          </tbody>
          <?php } 
          else{
          ?>
          <p>No ordered items found.</p>
          <?php
          } ?>
        </table> 
      </div>

      <?php
      }
      else{
      ?>
      <p>No order details found.</p>
      <?php
      }
      ?>

    </div>

<?php
require('footer.php');
?>