<?php 
require('connection.inc.php'); 
require('function.inc.php');
require('add_to_cart.inc.php');
$pid = get_safe_value($con, $_POST['pid']);
$pid = decrypt_id($pid);
$qty = get_safe_value($con, $_POST['qty']);
$type = get_safe_value($con, $_POST['type']);

$check_pid = mysqli_query($con, "select * from products where id='$pid'");

if(!isset($_POST['token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['product_and_my_cart_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['product_and_my_cart_form']) || ($_POST['token'] !== $_SESSION['csrf_token']['product_and_my_cart_form'])){
    echo "Error: Multiple tabs are open/token expired/invalid token";
    die();
}
else if(mysqli_num_rows($check_pid)<1){
    echo "invalid_product_id";
    die();
}
else if($type!='add' && $type!='remove' && $type!='update'){
    echo "invalid_type";
    die();
}

$productSoldQtyByProductId = productSoldQtyByProductId($con, $pid);
$productQty = productQty($con, $pid);
$qty_left = $productQty - $productSoldQtyByProductId;

$obj = new add_to_cart();

if($type=='add'){
if(!preg_match('/^([0-9]*)$/', $qty)){
    echo "invalid_qty_value";
    die();
}
else if($qty>$qty_left){
    echo "quantity_not_available";
    die();
}
else if($qty<1){
    echo "minimum_quantity_is_one";
    die();
}
$obj -> addProduct($pid, $qty);
}

if($type=='remove'){
    if($qty!='undefined'){
        echo "quantity_cannot_be_changed_during_remove";
        die();
    }
    $obj -> removeProduct($pid, $qty);
}

if($type=='update'){
    if(!preg_match('/^([0-9]*)$/', $qty)){
        echo "invalid_qty_value";
        die();
    }
    else if($qty>$qty_left){
        echo "quantity_not_available";
        die();
    }
    else if($qty<1){
        echo "minimum_quantity_is_one";
        die();
    }
    $obj -> updateProduct($pid, $qty);
}

// unset($_SESSION['csrf_token']['product_and_my_cart_form']);
session_regenerate_id(true);
echo $obj -> totalProduct();
?>