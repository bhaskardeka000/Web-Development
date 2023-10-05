<?php
require('top.inc.php');
$order_id = 5;


if(isset($_POST['update_payment_status'])){
  $update_payment_status = $_POST['update_payment_status'];
  mysqli_query($con, "update orders_check set payment_status = '$update_payment_status' where id = '$order_id' ");

?>
<script>
window.location.href="order_master_check.php";
</script>
<?php
}
// header("Location: order_master_check.php");
?>

<div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Order Details</h3>
          <h4 class="card-title order_id_heading_h4">Order ID: <?php echo $order_id ?></h4>
        </div>
        <!-- <div class="row"></div> -->
        <div class="card mb-0 order_master_details_card_mb_div">        
            <div class="card-body">
           

                                 
                                 <!-- Start-Update payment status -->
                                 <?php 
                                 $payment_status = mysqli_fetch_assoc(mysqli_query($con, "select payment_status from orders_check where id = '$order_id' "));
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
                                          <select id="select_payment_status" name="update_payment_status"> 
                                          <option disabled>Select Status</option>
                                          <?php 
                                        //   $res = mysqli_query($con, "select id,payment_status from orders_check group by payment_status order by payment_status desc");
                                        //   while($row = mysqli_fetch_assoc($res)){
                                        //   if($row['payment_status']=='pending'){
                                        //     $display_payment_status_name = "Pending";
                                        //   }
                                        //   else if($row['payment_status']=='failure'){
                                        //     $display_payment_status_name = "Failed";
                                        //   }
                                        //   else if($row['payment_status']=='success'){
                                        //     $display_payment_status_name = "Complete";
                                        //   }





                                        // $payment_status_array = array("pending","failure","success");
                                        // $matched_value_key = array_search($payment_status['payment_status'], $payment_status_array);
                                        // // if($row['payment_status'] == $payment_status['payment_status']){
                                        // echo "<option selected value=".$payment_status_array[$matched_value_key].">".$payment_status_array[$matched_value_key]."</option>";
                                        // unset($payment_status_array[$matched_value_key]);
                                        // foreach($payment_status_array as $item){
                                        //     echo "<option value=".$item.">".$item."</option>";
                                        // }




                                   
                                        //   }
                                        //   else{
                                        //   echo "<option value=".$row['payment_status'].">".$display_payment_status_name."</option>";

                                        // echo $payment_status_array[$matched_value_key];
                                        // $matched_string = $payment_status_array[$matched_value_key];
                                        // unset($payment_status_array[$matched_value_key]);
                                        // print_r($payment_status_array);
                                        // echo (string)$payment_status_array;
                                        // echo implode(" ",$payment_status_array);
                                        // unset($payment_status_array[$matched_value_key]);
                                        // foreach($payment_status_array as $item){
                                        //     echo "<option value=".$item.">".$item."</option>";
                                        // }

                                        // echo "<button>Sort Options</button>";
                                            //  }





                                            // $payment_status_array = array("pending","failure","success");
                                            // if($payment_status['payment_status']==$payment_status_array[0]){
                                            //     // $payment_status_show = "Pending";
                                            //     $is_selected = "selected";
                                            // }
                                            // else{
                                            //     // $payment_status_show = "Pending";
                                            //     $is_selected = "";
                                            // }
                                            // echo "<option $is_selected value='pending'>Pending</option>";
                                            
                                            // if($payment_status['payment_status']==$payment_status_array[1]){
                                            //     // $payment_status_show = "Pending";
                                            //     $is_selected = "selected";
                                            // }
                                            // else{
                                            //     // $payment_status_show = "Pending";
                                            //     $is_selected = "";
                                            // }
                                            // echo "<option $is_selected value='failure'>Failure</option>";

                                            // if($payment_status['payment_status']==$payment_status_array[2]){
                                            //     // $payment_status_show = "Pending";
                                            //     $is_selected = "selected";
                                            // }
                                            // else{
                                            //     // $payment_status_show = "Pending";
                                            //     $is_selected = "";
                                            // }
                                            // echo "<option $is_selected value='success'>Complete</option>";

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






                                        // $payment_status_array = array("pending","failure","success");
                                        // $payment_status_show_array = array("Pending","Failed","Complete");
                                        // foreach($payment_status_array as $key){
                                        //   foreach($payment_status_show_array as $i){
                                        //     if($key==$i){
                                        //         $payment_status_show = "Pending";
                                        //     }
                                        //     else if($key==$i){
                                        //         $payment_status_show = "Failed";
                                        //     }
                                        //     else if($key==$i){
                                        //         $payment_status_show = "Complete";
                                        //     }
                                        //   }
                                        //     if($payment_status['payment_status']==$key){
                                        //         echo "<option selected value='$key'>$payment_status_show</option>";
                                        //     }
                                        //     else{
                                        //         echo "<option value='$key'>$payment_status_show</option>";
                                        //     }
                                        // }




                                          ?>
                                                </select>
                                         <br>
                                         <button type="submit" name="submit" id="order_status_update_btn"><span>UPDATE</span></button>
                                         <br>

                                          </form>
                                          <!-- <button onclick = "sortOptions()"> Sort Options </button> -->
                                          <!-- </select> -->
                                          <!-- <br> -->
                                          <!-- <button type="submit" name="submit" id="order_status_update_btn"><span>UPDATE</span></button>
                                          <br> -->
                                    <!-- </form> -->
                                    <!-- End-Update payment status -->

                                   

                                    
              
          </div>

         
        </div>
    </div>

<?php require('footer.inc.php'); ?>

<!-- <script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"> </script> -->
<!-- <script>
      function sortOptions() {
         var dorpdown = $('.nice-select');
         dorpdown.html(dorpdown.find('.option').sort(function (option1, option2) {
            return $(option1).text() < $(option2).text() ? -1 : 1;
         }));
      }
   </script> -->