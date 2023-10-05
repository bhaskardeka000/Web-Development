<?php
require('top.inc.php');
$partners_request_id = get_safe_value($con, $_GET['id']);
$partners_request_id = decrypt_id($partners_request_id);

if(!isset($_GET['form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['partners_details_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['partners_details_form']) || ($_GET['form_token'] !== $_SESSION['csrf_token']['partners_details_form'])){
  ?>
  <script>
  alert("Error occured: Multiple tabs are open/token expired/invalid token.");
  window.location.href = "partners.php";
  </script>
  <?php
  die();
}
else if(strpos($partners_request_id,".") !== false || is_numeric($partners_request_id) === false){
   ?>
   <script>
   window.location.href="partners.php";
   </script>
   <?php
   die();
   }
?>

<div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Partner Details</h3>
          <h4 class="card-title partners_request_id_heading_h4">Request ID: <?php echo $partners_request_id ?></h4>
        </div>
        <!-- <div class="row"></div> -->
        <div class="card mb-0 partners_master_details_card_mb_div">        
            <div class="card-body">
                  <?php
                  $res1 = mysqli_query($con, "select * from partners where id = '$partners_request_id'");

                  if(mysqli_num_rows($res1)>0){
                    $info = mysqli_fetch_assoc($res1);
                  ?>

                    <p class="partnership_request_details_of_partner">Requested On: <?php echo $info['added_on'] ?></p>

                    <p class="partnership_request_details_of_partner">Name: <?php echo ucwords($info['name']) ?></p>

                    <p class="partnership_request_details_of_partner">Email: <?php echo $info['email'] ?></p>

                    <p class="partnership_request_details_of_partner">Mobile: <?php echo $info['mobile'] ?></p>

                    <p class="partnership_request_details_of_partner">Address: <?php echo ucfirst($info['address']) ?>, <?php echo $info['state']; ?>, <?php echo $info['pincode']; ?></p>

                    <p class="partnership_request_details_of_partner"><?php echo $info['gst_pan_card'] ?>: <?php echo $info['gst_pan_card_number'] ?></p>

                    <p class="partnership_request_details_of_partner"><?php echo $info['license'] ?>: <?php echo $info['license_number'] ?></p>

                    <p class="partnership_request_details_of_partner">Applied for: <?php echo $info['applied_for'] ?></p>

                    <p class="partnership_request_details_of_partner">Referred by: <?php echo ucwords($info['referred_by']) ?></p>

                    <p class="partnership_request_details_of_partner">Business start date: <?php echo $info['business_start_date'] ?></p>

                    <p class="partnership_request_details_of_partner">Partner declared: <?php echo $info['declared'] ?></p>

              <?php
              }else{
              ?>
                <p class="partnership_request_details_of_partner">No partnership request details found.</p>
            <?php
            }
              ?>
                  
            </div>
        </div>
    </div>

<?php require('footer.inc.php'); ?>