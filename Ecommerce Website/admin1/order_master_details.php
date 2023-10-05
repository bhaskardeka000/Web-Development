<?php
require('top.inc.php');
$order_id = get_safe_value($con, $_GET['id']);
$order_id = decrypt_id($order_id);
$order_id_check = mysqli_query($con, "select * from orders where id = '$order_id'");
$previous_page = get_safe_value($con, $_GET['previous_page']);

if($previous_page!=='order_master' && $previous_page!=='pending_order_master'){
  $_SESSION['Message_error'] = 'Previous page not found.';
  ?>
  <script>
  window.location.href="order_master.php";
  </script>
  <?php
  die();
}
else if(!isset($_GET['form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['order_master_and_pending_order_master_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['order_master_and_pending_order_master_form']) || ($_GET['form_token'] !== $_SESSION['csrf_token']['order_master_and_pending_order_master_form'])){
  if($previous_page=='order_master'){
    $previous_page_url = "order_master.php";
  }
  else if($previous_page=='pending_order_master'){
    $previous_page_url = "pending_order_master.php";
  }
  ?>
  <script>
  alert("Error occured: Multiple tabs are open/token expired/invalid token.");
  window.location.href = "<?php echo $previous_page_url ?>";
  </script>
  <?php
  die();
}
else if(mysqli_num_rows($order_id_check)<1 || strpos($order_id,".") !== false || is_numeric($order_id) === false){
  // unset($_SESSION['csrf_token']);
  $_SESSION['Message_error'] = 'Invalid career application ID.';
?>
<script>
window.location.href="order_master.php";
</script>
<?php
die();
}

if(isset($_POST['update_order_status'])){
  if(!isset($_POST['update_status_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['update_status_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['update_status_form']) || ($_POST['update_status_form_token'] !== $_SESSION['csrf_token']['update_status_form'])){
    die("<p class='token_error'>Invalid token!</p>");
 }
$update_order_status = get_safe_value($con, $_POST['update_order_status']);
$update_order_status = decrypt_id($update_order_status);
if($update_order_status==''){
    // $msg_error = '2';
    $_SESSION['Message_error'] = 'All fields are reqiured.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
}
else if(!preg_match('/^([0-9]*)$/', $update_order_status)){
    // $msg_error = '1';
    $_SESSION['Message_error'] = 'Invalid order status type.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
}
else if($update_order_status!='1' && $update_order_status!='2' && $update_order_status!='3' && $update_order_status!='4' && $update_order_status!='5'){
    // $msg_error = '1';
    $_SESSION['Message_error'] = 'Invalid order status.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
}
mysqli_query($con, "update orders set order_status = '$update_order_status' where id = '$order_id' ");
unset($_SESSION['last_generated_token_time']['update_status_form']);
unset($_SESSION['csrf_token']['update_status_form']);
session_regenerate_id(true);
$_SESSION['Message_success'] = 'Order status updated successfully.';
// unset($_SESSION['csrf_token']);
?>
<script>
window.location.href="order_master_details.php?id=<?php echo encrypt_id($order_id) ?>&form_token=<?php echo $_GET['form_token']?>";
</script>
<?php
die();
}

if(isset($_POST['update_payment_status'])){
  if(!isset($_POST['update_status_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['update_status_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['update_status_form']) || ($_POST['update_status_form_token'] !== $_SESSION['csrf_token']['update_status_form'])){
    die("<p class='token_error'>Invalid token!</p>");
 }
  $update_payment_status = get_safe_value($con, $_POST['update_payment_status']);
  if($update_payment_status==''){
      // $msg_error = '4';
    $_SESSION['Message_error'] = 'All fields are reqiured.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = window.location.href;
    </script>
    <?php
    die();
  }
  else if($update_payment_status!='pending' && $update_payment_status!='failure' && $update_payment_status!='success'){
  // $msg_error = '3';
  $_SESSION['Message_error'] = 'Invalid payment status.';
  // unset($_SESSION['csrf_token']);
  ?>
  <script>
  window.location.href = window.location.href;
  </script>
  <?php
  die();
  }
mysqli_query($con, "update orders set payment_status = '$update_payment_status' where id = '$order_id' ");
unset($_SESSION['last_generated_token_time']['update_status_form']);
unset($_SESSION['csrf_token']['update_status_form']);
session_regenerate_id(true);
$_SESSION['Message_success'] = 'Payment status updated successfully.';
// unset($_SESSION['csrf_token']);
?>
<script>
window.location.href="order_master_details.php?id=<?php echo encrypt_id($order_id) ?>&form_token=<?php echo $_GET['form_token'] ?>";
</script>
<?php
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['update_status_form'])){
  $update_status_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['update_status_form'] = $update_status_form_generated_token;
  $_SESSION['last_generated_token_time']['update_status_form'] = time();
}
else{
  $interval = 60 * 25;
  if(time() -  $_SESSION['last_generated_token_time']['update_status_form']>= $interval){
      $update_status_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['update_status_form'] = $update_status_form_generated_token;
      $_SESSION['last_generated_token_time']['update_status_form'] = time();
  }
  else{
      $update_status_form_generated_token = $_SESSION['csrf_token']['update_status_form'];
  }
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['download_invoice_form'])){
  $download_invoice_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['download_invoice_form'] = $download_invoice_form_generated_token;
  $_SESSION['last_generated_token_time']['download_invoice_form'] = time();
}
else{
  $interval = 60 * 25;
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

<div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Order Details</h3>
          <h4 class="card-title order_id_heading_h4">Order ID: <?php echo $order_id ?></h4>
        </div>
        <!-- <div class="row"></div> -->
        <div class="card mb-0 order_master_details_card_mb_div">        
            <div class="card-body">
                <?php
                  if(isset($_SESSION['Message_error'])){
                  ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['Message_error'] ?>
                        <button type="button" class="btn-close alert_box_close_btn" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  <?php
                  unset($_SESSION['Message_error']);
                  }

                  else if(isset($_SESSION['Message_success'])){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <?php echo $_SESSION['Message_success'] ?>
                          <button type="button" class="btn-close alert_box_close_btn" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                    unset($_SESSION['Message_success']);
                    }
                ?>
                <div class="table-responsive">
                  <table class="table datatable order_details_table">
                    <thead>
                      <tr>
                      <th>Product Name</th>
                      <th>Product Image</th>
                      <th>Price</th>
                      <th>Qty</th>
                      <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                                     <?php 
                                     $res = mysqli_query($con, "select distinct(order_details.id), order_details.*, orders.pincode, orders.state, orders.house_no, orders.street_address, orders.city from order_details, orders where order_details.order_id = '$order_id' group by order_details.name order by order_details.id");
                                     $total_price = 0;
                                     if(mysqli_num_rows($res)>0){
                                     while($row = mysqli_fetch_assoc($res)){
                                    //  $address = $row['address'];
                                    //  $house_no = $row['house_no'];
                                    //  $city = $row['city'];
                                    //  $pincode = $row['pincode'];
                                     $total_price = $total_price + ($row['qty'] * $row['price']);
                                     ?>
                                    <tr>
                                       <td class="order_details_product_name_td"><?php echo $row['name'] ?></td>
                                       <td><a href="<?php echo ORDERED_ITEMS_IMAGE_SITE_PATH.$row['image'] ?>" target="_blank" class="product-img"><img src="<?php echo ORDERED_ITEMS_IMAGE_SITE_PATH.$row['image'] ?>"></a></td>
                                       <td>₹<?php echo $row['price']?></td>
                                       <td><?php echo $row['qty']?></td>
                                       <td>₹<?php echo $row['price']*$row['qty']?></td>
                                    </tr>           
                                    <?php } } else{ 
                                    ?>
                                    <tr class="no_results_found_tr">
                                    <td>No order details found</td>
                                    </tr>
                                    <?php
                                    } ?>
                                    <tr class="order_details_total_price_tr">
                                       <td colspan="4"></td>
                                       <td class="order_details_total_price_td">GRAND TOTAL: ₹<?php echo $total_price?></td>
                                    </tr>
                                 </tbody>
                  </table>

                </div>

                  <?php
                                 $res1 = mysqli_query($con, "select orders.*, users.* from orders, users where orders.user_id = users.id and orders.id = '$order_id'");
                                 if(mysqli_num_rows($res1)>0){
                                 $info = mysqli_fetch_assoc($res1);
                                 ?>
                                 
                                 <!-- Start-Update payment status -->
                                 <?php 
                                 $payment_status = mysqli_fetch_assoc(mysqli_query($con, "select payment_status from orders where id = '$order_id' "));
                                 ?>
                                <p class="payment_details_of_customer">Payment Status: 
                                <?php 
                                if($payment_status['payment_status'] =='pending'){
                                  echo "Pending";
                                }
                                else if($payment_status['payment_status'] =='failure'){
                                  echo "Failed";
                                }
                                else if($payment_status['payment_status'] =='success'){
                                  echo "Complete";
                                }
                                  
                                ?></p>
                                
              
                                  <p class="payment_details_of_customer">Update payment status: &nbsp;</p>
                                    <form method="post" class="payment_status_update_form">
                                    <input type="hidden" name="update_status_form_token" value="<?php echo $update_status_form_generated_token ?>">
                                          <select name="update_payment_status"> 
                                          <option disabled>Select Payment Status</option>
                                          <?php 
                                            $payment_status_array = array("pending","failure","success");
                                            foreach($payment_status_array as $key){
                                                if($key=='pending'){
                                                    $payment_status_show = "Pending";
                                                }
                                                else if($key=='failure'){
                                                    $payment_status_show = "Failed";
                                                }
                                                else if($key=='success'){
                                                    $payment_status_show = "Complete";
                                                }
                                                if($payment_status['payment_status']==$key){
                                                    echo "<option selected value='$key'>$payment_status_show</option>";
                                                }
                                                else{
                                                    echo "<option value='$key'>$payment_status_show</option>";
                                                }
                                            }
                                          ?>
                                          </select>
                                          <br>
                                          <button type="submit" name="submit" id="order_status_update_btn"><span>UPDATE</span></button>
                                          <br>
                                    </form>
                                    <!-- End-Update payment status -->

                                    
                                 <!-- Start-Update order status -->
                                 <?php 
                                 $order_status_query = mysqli_query($con, "select order_status.name from order_status, orders where orders.id = '$order_id' and orders.order_status = order_status.id");
                                 $order_status = mysqli_fetch_assoc($order_status_query);
                                 ?>
                                <p class="order_details_of_customer">Order Status:
                                  <?php 
                                  if(mysqli_num_rows($order_status_query)>0){
                                    echo $order_status['name'];
                                  }
                                  
                                  ?></p>
                                
              
                                  <p class="order_details_of_customer">Update order status: &nbsp;</p>
                                    <form method="post">
                                    <input type="hidden" name="update_status_form_token" value="<?php echo $update_status_form_generated_token ?>">
                                          <select name="update_order_status"> 
                                          <option disabled>Select Order Status</option>
                                          <?php 
                                          $res = mysqli_query($con, "select * from order_status");
                                          while($row = mysqli_fetch_assoc($res)){
                                          if($row['name'] == $order_status['name']){
                                          echo "<option selected value=".encrypt_id($row['id']).">".$row['name']."</option>";
                                          }
                                          else{
                                          echo "<option value=".encrypt_id($row['id']).">".$row['name']."</option>";
                                                }
                              
                                             }
                                          ?>
                                          </select>
                                          <br>
                                          <button type="submit" name="submit" id="order_status_update_btn"><span>UPDATE</span></button>
                                          <br>
                                    </form>
                                    <!-- End-Update order status -->
                                    
            </div>
        </div>
        
        <div class="card mb-0">
          <div class="card-body">
              <p class="order_details_of_customer">Ordered By: <?php echo ucwords($info['name']) ?></p>

              <p class="order_details_of_customer">Mobile: <?php echo $info['mobile'] ?></p>

              <p class="order_details_of_customer">Email: <?php echo $info['email'] ?></p>

              <p class="order_details_of_customer">Address: <?php echo ucfirst($info['house_no']) ?>, <?php echo $info['street_address'] ?>, <?php echo $info['city'] ?>, <?php echo $info['state'] ?>, <?php echo $info['pincode'] ?></p>

              <?php
              $check_payment_status = mysqli_query($con, "select * from orders where id = '$order_id' and payment_status = 'success' ");
              if(mysqli_num_rows($check_payment_status)>0){
              ?>
              
              <div class="download_invoice">
              <p class="order_details_of_customer">Invoice:</p>
              <form id="download_invoice_form" action="download_invoice.php" method="post">
                  <input type="hidden" name="download_invoice_form_token" value="<?php echo $download_invoice_form_generated_token ?>">
                  <input type="hidden" name="order_id" value="<?php echo encrypt_id($order_id) ?>">
               </form>
              <a data-bs-toggle="tooltip" data-bs-original-title="PDF" aria-label="PDF" onclick="document.forms['download_invoice_form'].submit()"><img src="assets/img/icons/pdf.svg" alt="img"></a>
              </div>
              <?php } ?>
              
              <?php
              }
              ?>
          </div>
        </div>

    </div>

<?php require('footer.inc.php'); ?>