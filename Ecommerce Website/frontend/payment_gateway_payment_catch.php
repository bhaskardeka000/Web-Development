<?php
require('connection.inc.php'); 
require('function.inc.php');
echo '<b>Transaction In Process, Please do not reload</b>';
$payment_mode=$_POST['mode'];
$pay_id=$_POST['mihpayid'];
$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$SALT = "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC/K0Zbf60KlwxiMrQ2uxfxpOYX4t5fDe8HQald8zmu30NgIs13/OpJNz8gWl9h7YFOJW1XbokAA3W0IvbhsPuvC+eGbpWJC0q0ExRqDIM2BxpRGlsfmZT7oIfgakwaNd5BljuNrAYkcIe22D83zQC5w98Gqmv0TvHBgd7kKDEMqvvHm46gOzEvjuRN9/zc1i8zuFJk00FaMbcrRlyZMCGblaXbozgpcEvAvhDE4etWBfJ/0VZuXjOVmD90bf+DN3wGtShcs/Dm+ZzpYgSYW2wLhZFX2vNQaeAjmTbU3KsD8kwf+wfiA65axCzSARtKjrOfAoLmoIagRPtYL7RODaHDAgMBAAECggEBALoL/qQrxJeK21VyLSsauDnHFttmQq5VnCv+vjsd7CSBSkv0cuz0anqo1rnA2hUvFOmdySUPASvPMi0G3ihVmwwH1OJjGwrNv30zGGoBFW1uSjFmKgq96F1fJP3F1Zyokk5YTEsbgLrT/XB4UkYXMD6aHqKZFwkkD2oY33hCmUHOMtXvQqNNlF8hBCayXJ2PQMlZvsMwIFIISJhcO929AsfNRyRiZkSYhTXuVdjzK9fdkALvJe3YJPd/qxm0GDMNwL1t/75NMLXxKYd23i9BdYGHVpaouXD/GnddQw5lgNiyTJ0eGI6vTb/95ONIpXwwv0T9N6JN7+uFIHcq81N6nLECgYEA5pawJ89VtHvsfae14jYM6ry+OwOdyWTBF0nkYVwFXgzEWLIxYV/SSfarIrGuE6WUKaG0/rFYaBQViA+s8G4FZlE1VsIp6tcUvHz1DeoS24V8dZjf8jwMfy9ZgTK8urbLxWSJ33FH8GreyeDsxC0o4GNkbdpiqCeCXb54brDG/NkCgYEA1Dx9obgkkoFmo6zoK854dBnxx0cj3cdNvBD3XBIFF8lvFebzc7FHXgb0wnbyn8s37Vm4lwXgKbWtt5WxXJE9hElg3DHYXRt/jlopW4++j69MIh2mtA6ecYp9+AelWq9B824z8BKGB0VWfGmDb/fx1ZofeXgoGwyXAq5gfzzh4fsCgYB7pE8+eXFGPrC3S+c+LadNcvk54Z2IsKrM1wVLozEJliTuPlY2FVBH8qkfCFEEHePNUvUfIG78F9DXzTf5D7V7gI3uQFyDnOJ0kzg/RsTnyrLKx7dFRyeYRwZiPZdvMrce1+MJ2c8uPc/KRf4Ozvw9HW5rbQ87hTvlEk23ZLi+OQKBgA9jk3h2cbBt0ZNspikG/5TrjKx2bBNYsDpCwKzcYaIn6PYdmOl6oUIgHv86wLz1b0i2iLvqoSZlFgOJxyJ/JYbCC1PsCVQ2+jjIMNeCxL6GZ27R15SWusZg1GF3rHW234FXLEzsCuvcCzlaLT2hLNfgJQgZvk63yvtWyYhwUbChAoGBAMabzpYHKno7v78WxWddV+YvnPeMAkrM8VgMkDLO8z0FfPswgOWpyBOb1eNR3lYy0fAguz1IH4ARkzG7i9v8XUiG0uOYLirpO0ZxQFOjko3wn+eq+T0FJkEiR7GnzCbxLXhbUOH4EMXNKHsbp5oltRLEs+MKwnWy7Ga2c47vTC85";
$udf5=$_POST["udf5"];
$sentHashString = hash('sha512', $SALT.'|'.$status.'||||||'.$udf5.'|||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key);


if($sentHashString != $posted_hash || $status!='success'){
	// mysqli_query($con,"update orders set payment_status='$status', mihpayid='$pay_id' where txnid='$txnid'");
	mysqli_query($con, "update orders join transactions on orders.id=transactions.order_id set orders.payment_status='$status', orders.mihpayid='$pay_id' where transactions.txnid='$txnid'");
	unset($_SESSION['last_generated_token_time']['product_and_my_cart_form']);
    unset($_SESSION['csrf_token']['product_and_my_cart_form']);
    unset($_SESSION['last_generated_token_time']['checkout_form']);
    unset($_SESSION['csrf_token']['checkout_form']);
	session_regenerate_id(true);
	// if(!isset($_SESSION['USER_LOGIN'])){
	// $row = mysqli_fetch_assoc(mysqli_query($con, "select users.* from users, orders where orders.mihpayid = '$pay_id' and users.id = orders.user_id "));
	// $_SESSION['USER_LOGIN'] = 'yes';
    // $_SESSION['USER_ID'] = $row['id'];
    // $_SESSION['name'] = $row['USER_NAME'];
	// }
?>
<script>
window.location.href="payment_fail.php";
</script>
<?php
die();
}
else{
	// mysqli_query($con,"update orders set payment_status='$status', mihpayid='$pay_id' where txnid='$txnid'");
	mysqli_query($con, "update orders join transactions on orders.id=transactions.order_id set orders.payment_status='$status', orders.mihpayid='$pay_id' where transactions.txnid='$txnid'");
	// $order_details_id = mysqli_fetch_assoc(mysqli_query($con, "select id from orders where txnid='$txnid'"));
	$order_details_id = mysqli_fetch_assoc(mysqli_query($con, "select orders.id from orders, transactions where (orders.id=transactions.order_id) and txnid='$txnid'"));
	$user_id = $_SESSION['USER_ID'];
	email_invoice($con, $order_details_id['id'], $user_id);
	unset($_SESSION['last_generated_token_time']['product_and_my_cart_form']);
    unset($_SESSION['csrf_token']['product_and_my_cart_form']);
    unset($_SESSION['last_generated_token_time']['checkout_form']);
    unset($_SESSION['csrf_token']['checkout_form']);
	session_regenerate_id(true);
	// if(!isset($_SESSION['USER_LOGIN'])){
	// 	$row = mysqli_fetch_assoc(mysqli_query($con, "select users.* from users, orders where orders.mihpayid = '$pay_id' and users.id = orders.user_id "));
	// 	$_SESSION['USER_LOGIN'] = 'yes';
	// 	$_SESSION['USER_ID'] = $row['id'];
	// 	$_SESSION['name'] = $row['USER_NAME'];
	// 	}
	?>
<script>
window.location.href="payment_complete.php";
</script>
<?php
die();
}
?>