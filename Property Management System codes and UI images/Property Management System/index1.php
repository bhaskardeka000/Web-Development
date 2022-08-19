<?php
session_start();
if(!isset($_SESSION['IS_LOGIN'])){
    header('Location:login.php');  
}
?>

<?php include('top1.php'); ?>
<div class="nameclass">
        <h3 id="welcomeh3">WELCOME <?php echo $_SESSION['ADMIN_USER']?></h3>
</div>
<?php include('manage_property1.php'); ?>
