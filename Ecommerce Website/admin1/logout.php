<?php
require('connection.inc.php');
if(!isset($_POST['logout_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['logout_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['logout_form']) || ($_POST['logout_form_token'] !== $_SESSION['csrf_token']['logout_form'])){
    ?>
        <script>
        alert("Error occured: Multiple tabs are open/token expired/invalid token.");
        window.location.href = "index.php";
        </script>
        <?php
        die();
}
unset($_SESSION['ADMIN_LOGIN']);
unset($_SESSION['ADMIN_ID']);
unset($_SESSION['ADMIN_NAME']);
unset($_SESSION['last_generated_token_time']['logout_form']);
unset($_SESSION['csrf_token']['logout_form']);
session_regenerate_id(true);
header('location: login.php');
die();
?>