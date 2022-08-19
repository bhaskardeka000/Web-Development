<?php include('database.inc.php');
$msg=""; 

if(isset($_POST['submit'])){
$name = $_POST['Name'];
$phone = $_POST['Phone'];
$mail = $_POST['Mail'];
$message = $_POST['Message'];

$sql = "INSERT into contact_us(Name,Phone,Mail,Message) values('$name','$phone','$mail','$message')";
mysqli_query($con,$sql);
$msg = nl2br("Thank You!\nYour message has been successfully sent. We will contact you very soon!");
}
?>

<?php include('top.php');?>
<div class="wbg_contact">
</div>
<div class="contact_main_div">
    <div class = "contact-form">
    <form method="post">
     <h1>Contact Us</h1>
     <div class = "texb">
         <label>Full-Name </label>
         <input type="text "name="Name" placeholder=" Enter your Name" required>
     </div>
     <div class = "texb">
        <label>PhoneNo </label>
        <input type="number" name="Phone" placeholder=" Enter your phone Number" required>
    </div>
    <div class = "texb">
        <label>E-Mail </label>
        <input type="text" name="Mail" value="" placeholder=" Enter your E-mail" required>
    </div>
    <div class = "texb">
        <label>Message: </label>
        <textarea name="Message" required></textarea>
    </div>
    <input type="submit" name="submit" class="btn">
   <br> <a style="font-size:14px;"> <?php echo $msg; ?> </a>
         <div class="contact_us_message_div">
         <a id="contact_us_no">Contact our 24/7 call center:</a> <span id="contact_span">+001 345 6889</span> 
        </div>
     </form>
    </div>
</div>
<?php include('footer.php');?>