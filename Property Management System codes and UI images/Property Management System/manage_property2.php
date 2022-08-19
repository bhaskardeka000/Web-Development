<?php 
session_start();
if(!isset($_SESSION['IS_LOGIN'])){
    header('Location:login.php');  
}
?>

<?php include('top1.php'); ?> 
<div class="wbg4">
</div>
<?php include('manage_property1.php'); ?> 
