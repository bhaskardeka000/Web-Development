<?php
ob_start();
include('mpdf_library_and_invoice_assets/mpdf/vendor/autoload.php');
require('connection.inc.php');
require('function.inc.php');

if(!isset($_SESSION['USER_ID'])){
   header('location:login.php');
   die();
}
else if(!isset($_POST['download_invoice_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['download_invoice_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['download_invoice_form']) || ($_POST['download_invoice_form_token'] !== $_SESSION['csrf_token']['download_invoice_form'])){
   ?>
   <script>
   alert("Error: Multiple tabs are open/token expired/invalid token");
   window.location.href = "index.php";
   </script>
   <?php
   die();
}

$order_id = get_safe_value($con, $_POST['order_id']);
$order_id = decrypt_id($order_id);
$uid = $_SESSION['USER_ID'];
$check_order_id = mysqli_query($con, "select * from orders where id = '$order_id' and user_id = '$uid'");

if($order_id=='' || strpos($order_id,".") !== false || is_numeric($order_id) === false || mysqli_num_rows($check_order_id)<1){
   header('location:my_orders.php');
   die();
}

$css=file_get_contents('mpdf_library_and_invoice_assets/css/style.css');
$html='<div class="main_div">
<div class="company_details_main_div">
   <div class="company_name_and_address_div">
      <p class="company_name">SCOTCH CLUB INTERNATIONAL</p>
      <h6 class="company_address_h6">House no 23, Loknath Path,</h6>
      <h6 class="company_address_h6">Opposite of HP Petrol Pump,</h6>
      <h6 class="company_address_h6">Near Adagudam, Lalganesh, Guwahati,</h6>
      <h6 class="company_address_h6">Assam, Pincode: 781034</h6>
      <h6 class="company_address_h6">Mobile No: 7002497482</h6>
    </div>
    <div class="invoice_div">
      <div>
         <h5 class="invoice_word_h5">INVOICE</h5>
      </div>
    </div>
</div>

<div class="delivery_details_main_div">
   <div class="delivery_address_div">
      <p class="delivery_address_p">Delivery Address:</p>';
     
      $res = mysqli_query($con, "select orders.id as order_id, orders.pincode as order_pincode, orders.state as order_state, orders.house_no as order_house_no, orders.street_address as order_street_address, orders.city as order_city, orders.payment_type as order_payment_type, DATE_FORMAT(orders.added_on,'%Y-%m-%d') as order_date, order_status.name as order_status_str, users.name as user_name, users.email as user_email, users.mobile as user_mobile, invoices.invoice_no as order_invoice_no from orders join users on orders.user_id = users.id join order_status on orders.order_status = order_status.id join invoices on orders.id = invoices.order_id where orders.id = '$order_id' and users.id = '$uid' ");
      if(mysqli_num_rows($res)<1){
         header('location:my_orders.php');
         die();
      }
      $info = mysqli_fetch_assoc($res);
     
      $html.='<h6 class="user_name_h6">'.$info['user_name'].',</h6>
      <h6 class="delivery_address_h6">'.ucfirst($info['order_house_no']).',</h6>
      <h6 class="delivery_address_h6">'.$info['order_street_address'].',</h6>
      <h6 class="delivery_address_h6">'.$info['order_city'].', '.$info['order_state'].',</h6>
      <h6 class="delivery_address_h6">Pincode: '.$info['order_pincode'].'</h6>
      <h6 class="delivery_address_h6">Mobile No: '.$info['user_mobile'].'</h6>
    </div>
    <div class="invoice_no_order_id_order_date_and_payment_mode_div">
      <div>
      <p class="invoice_number">Invoice No:<span> '.$info['order_invoice_no'].'</span></p>
      <p class="order_id_number">Order ID:<span> '.$info['order_id'].'</span></p>
      <p class="order_date">Order Date:<span> '.$info['order_date'].'</span></p>
      <p class="payment_mode">Payment Mode:<span> '.strtoupper($info['order_payment_type']).'</span></p>
      </div>
    </div>
</div>

<div class="product_details_main_div">
   <table>
      <thead>
         <tr>
            <th class="product th_first">PRODUCT</th>
            <th class="price">PRICE</th>
            <th class="qty">QTY</th>
            <th class="sub_total">SUBTOTAL</th>
         </tr>
      </thead>
      <tbody>';
      $res1 = mysqli_query($con, "select distinct(order_details.id), order_details.* from order_details, orders where order_details.order_id = '$order_id' and orders.user_id = '$uid' ");
    //   if(mysqli_num_rows($res1)>0){
      $total_price = 0;
      while($row = mysqli_fetch_assoc($res1)){
      $total_price = $total_price + ($row['qty'] * $row['price']);

      $html.='<tr>
            <td class="td_first">'.$row['name'].'</td>
            <td>₹'.$row['price'].'</td>
            <td>'.$row['qty'].'</td>
            <td>₹'.$row['qty'] * $row['price'].'</td>
         </tr>';
      }
        $html.='<tr>
            <td class="grand_total" colspan="3">GRAND TOTAL</td>
            <td class="rupees_with_grand_total">₹'.$total_price.'</td>
         </tr>

      </tbody>

   </table>
</div>
   <p class="computer_generated_invoice_text">***This is a computer generated invoice***</p>  
</div>';

   $mpdf = new \Mpdf\Mpdf();
   $mpdf->WriteHTML($css,1);
   $mpdf->WriteHTML($html,2);
   $file_name = $info['order_id'].'.pdf';
   $mpdf->Output($file_name,'D');
   // unset($_SESSION['last_generated_token_time']['download_invoice_form']);
   // unset($_SESSION['csrf_token']['download_invoice_form']);
   session_regenerate_id(true);
?>