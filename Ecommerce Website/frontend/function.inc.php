<?php

function pr($arr){
echo '<pre>';
print_r($arr);
}

function prx($arr){
    echo '<pre>';
    print_r($arr);
    die();
}

function get_safe_value($con, $str){
    if($str!=''){
        $str = trim($str);
        return strip_tags(mysqli_real_escape_string($con, $str));
    }
}

function get_product($con, $limit='', $cat_id='', $product_id='', $search_str='', $sort_order=''){
$sql = "select products.*, categories.categories from products, categories where products.status = 1";
if($cat_id!=''){
    $sql.=" and products.categories_id = $cat_id";
}

if($product_id!=''){
    $sql.=" and products.id = $product_id";
}
$sql.=" and products.categories_id = categories.id";
if($search_str!=''){
$sql.=" and (products.name like '%$search_str%' or products.description like '%$search_str%')";
}
if($sort_order!=''){
$sql.=$sort_order;
}
else{
$sql.=" order by products.id desc";
}

if($limit!=''){
$sql.=" limit $limit";
}
$res = mysqli_query($con, $sql);
$data = array();
while($row = mysqli_fetch_assoc($res)){
$data[] = $row;
}
return $data;
}

function productSoldQtyByProductId($con, $pid){
    $sql = "select sum(order_details.qty) as qty from order_details, orders where orders.id = order_details.order_id and order_details.product_id = $pid and orders.order_status!=4 and ((orders.payment_type = 'payu' and orders.payment_status='success') or (orders.payment_type = 'cod' and orders.payment_status='success'))";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['qty'];
}

function productQty($con, $pid){
    $sql = "select qty from products where id = '$pid'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['qty'];
}

function email_invoice($con, $order_id, $uid){
    $res = mysqli_query($con, "select orders.id as order_id, orders.pincode as order_pincode, orders.state as order_state, orders.house_no as order_house_no, orders.street_address as order_street_address, orders.city as order_city, orders.payment_type as order_payment_type, DATE_FORMAT(orders.added_on,'%Y-%m-%d') as order_date, order_status.name as order_status_str, users.name as user_name, users.email as user_email, users.mobile as user_mobile from orders join users on orders.user_id = users.id join order_status on orders.order_status = order_status.id where orders.id = '$order_id' and users.id = '$uid'");
    $info = mysqli_fetch_assoc($res);

    $html = '<html>

    <body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;padding:70px 10px;">
      <table style="max-width:670px;margin:10px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);">
        <thead>
          <tr>
            <th style="text-align:left;font-size: 22px;">Hi, '.ucwords($info['user_name']).'</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2" style="height:7rem;font-size: 16px;">Thank you for ordering from Scotch Club International. This email is the receipt for your purchase.</td>
          </tr>
          <tr>
            <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
              <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;">Order ID:</span> '.$info['order_id'].'</p>
              <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;">Order Date:</span> '.$info['order_date'].'</p>
              <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;">Payment Mode:</span> <span style="text-transform: uppercase;">'.$info['order_payment_type'].'</span></p>
            </td>
          </tr>
          <tr>
            <td style="height:35px;"></td>
          </tr>
          <tr>
            <td style="width:50%;padding:20px;vertical-align:top;border: solid 1px #ddd; padding:10px 20px;">
            <p style="margin:0 0 10px 0;padding:0;font-size:14px;font-weight: bold;">Delivery Address: '.ucwords($info['user_name']).', <span style="font-weight: normal;">'.ucfirst($info['order_house_no']).', '.$info['order_street_address'].', '.$info['order_city'].', '.$info['order_state'].', Pincode: '.$info['order_pincode'].'</span></p>
              <p style="margin:0 0 10px 0;padding:0;font-size:14px;font-weight: bold;">Email: <span style="font-weight: normal;">'.$info['user_email'].'</span></p>
              <p style="margin:0 0 10px 0;padding:0;font-size:14px;font-weight: bold;">Mobile No: <span style="font-weight: normal;">'.$info['user_mobile'].'</span></p>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="font-size:14px;font-weight: bold;padding:30px 15px 0 15px;">Ordered Product Details:</td>
          </tr>
          <tr>
            <td colspan="2" style="padding:15px;">
            <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                               
                                  <tbody><tr>
                                    <th align="left" style="padding-bottom: 8px;border-bottom: 1px solid #EAEAEC;font-size: 14px;color: #85878E;">
                                      <p style="margin:0;">Product</p>
                                    </th>
                                    <th align="right" style="padding-bottom: 8px;border-bottom: 1px solid #EAEAEC;font-size: 14px;color: #85878E;">
                                      <p style="margin:0;">Subtotal</p>
                                    </th>
                                  </tr>';

                                  $res1 = mysqli_query($con, "select distinct(order_details.id), order_details.*  from order_details, orders where order_details.order_id = '$order_id' and orders. user_id = '$uid' ");
                                  $total_price = 0;
                                  while($row = mysqli_fetch_assoc($res1)){
                                  $total_price = $total_price + ($row['qty'] * $row['price']);

                                  $html.='<tr>
                                    <td width="80%" style="padding: 10px 0;color: #51545E;font-size: 14px;line-height: 18px;word-wrap: break-word;max-width: 0px;"><span>'.$row['name'].' (Qty: '.$row['qty'].')</span></td>
                                    <td class="width="20%" style="text-align: right;padding: 10px 0;color: #51545E;font-size: 14px;line-height: 18px;"><span>₹'.$row['qty'] * $row['price'].'</span></td>
                                  </tr>';
                                  }
                                  $html.='<tr>
                                    <td width="80%" valign="middle" style="padding-top: 15px;border-top: 1px solid #EAEAEC;font-size: 15px;">
                                      <p style="padding: 0 15px 0 0;margin: 0;text-align: right;font-weight: bold;color: #333333;">Total</p>
                                    </td>
                                    <td width="20%" valign="middle" style="padding-top: 15px;border-top: 1px solid #EAEAEC;font-size: 15px;">
                                      <p style="margin: 0;text-align: right;font-weight: bold;color: #333333;">₹'.$total_price.'</p>
                                    </td>
                                  </tr>
                                </tbody></table>
            </td>
          </tr>
        </tbody>
        <tfooter>
          <tr>
            <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;"><p style="margin: 7px 0;">Regards,</p><p style="margin: 7px 0;">Technical Team,</p><p style="margin: 7px 0;">Scotch Club International</p>
            </td>
          </tr>
        </tfooter>
      </table>
    </body>
    
    </html>';

    include('smtp/PHPMailerAutoload.php');
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="grostuff24@gmail.com";
	$mail->Password="koonzxdlyxabqqap";
	$mail->SetFrom("grostuff24@gmail.com");
	$mail->addAddress($info['user_email']);
	$mail->IsHTML(true);
	$mail->Subject="Scotch Club International - Order Receipt";
	$mail->Body= $html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
  try{
	if($mail->send()){
		echo "password_reset_mailed";
	}
  }
  catch(Exception){
		//echo "Error occur";
    die();
	}
}

function encrypt_id($id){
  $encrypt_method = "AES-256-CBC";
  $secret_key = "HYUI-PLMO-CVYUP-QCRR-MGPL-DSK";
  $initialization_vector = "XJOQICRTPUZNLRSS";
  $key = hash('sha256', $secret_key);
  $initialization_vector = substr(hash('sha256', $initialization_vector), 0, 16);
  $id = openssl_encrypt($id, $encrypt_method, $key, 0, $initialization_vector);
  $id = base64_encode($id);
  return $id;
}

function decrypt_id($id){
  $encrypt_method = "AES-256-CBC";
  $secret_key = "HYUI-PLMO-CVYUP-QCRR-MGPL-DSK";
  $initialization_vector = "XJOQICRTPUZNLRSS";
  $id = base64_decode($id);
  $key = hash('sha256', $secret_key);
  $initialization_vector = substr(hash('sha256', $initialization_vector), 0, 16);
  $id = openssl_decrypt($id, $encrypt_method, $key, 0, $initialization_vector);
  return $id;
}

function validate_name($name){
  $pattern_name = '/^[A-Za-z ]*$/';
  if(preg_match($pattern_name, $name) === 1){
    return 1;
  }
  else{
    return 0;
  }
}

function validate_email_address($email){
    if(is_array($email) || is_numeric($email) || is_bool($email) || is_float($email) || is_file($email) || is_dir($email) || is_int($email))
        return 0;
    else
    {
        $email=trim(strtolower($email));
        if(filter_var($email, FILTER_VALIDATE_EMAIL)!==false){
           return 1;
        }
        else
        {
            $pattern_email = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
            if(preg_match($pattern_email, $email) === 1){
               return 1; 
            }
            else{
               return 0;
            }
        }
    }
}

function validate_mobile_number($mobile){
  $pattern_mobile = '/^[0-9]{10}+$/';
  if(preg_match($pattern_mobile, $mobile) === 1){
    return 1; 
  }
  else{
    return 0;
  }
}

function validate_password($password){
  $number = preg_match('@[0-9]@', $password);
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $special_characters = preg_match('@[^\w]@', $password);

  if(strlen($password)>=6 && $number && $uppercase && $lowercase && $special_characters){
    return 1;
  }
  else{
    return 0;
  }
}

function validate_date($date){
  $format = "Y-m-d";
  if(date($format, strtotime($date)) == date($date)){
      return 1;
  }
  else{
      return 0;
  }
}
?>