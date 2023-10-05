<?php
require('top.inc.php');
$str = "";

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['order_master_and_pending_order_master_form'])){
  $order_master_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['order_master_and_pending_order_master_form'] = $order_master_form_generated_token;
  $_SESSION['last_generated_token_time']['order_master_and_pending_order_master_form'] = time();
}
else{
  $interval = 60 * 25;
  if(time() -  $_SESSION['last_generated_token_time']['order_master_and_pending_order_master_form']>= $interval){
      $order_master_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['order_master_and_pending_order_master_form'] = $order_master_form_generated_token;
      $_SESSION['last_generated_token_time']['order_master_and_pending_order_master_form'] = time();
  }
  else{
      $order_master_form_generated_token = $_SESSION['csrf_token']['order_master_and_pending_order_master_form'];
  }
}
?>

<div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Orders</h3>
          <h4 class="card-title pending_orders_link_heading_h4"><a class="pending_orders_link_heading_a" href="pending_order_master.php">Pending Orders</a></h4>
        </div>
        <!-- <div class="row"></div> -->
        <div class="card mb-0">
            <div class="card-body">
            <?php
                  if(isset($_SESSION['Message_error'])){
                  ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['Message_error'] ?>
                        <button type="button" class="btn-close alert_box_close_btn" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  <?php
                  unset($_SESSION['Message_error']);
                  }
                ?>
                <div class="table-responsive">
                    <div class="col-sm-7 col-md-5 col-lg-4 search_main_div">
                      <form action="order_master.php" method="get">
                        <div class="input-group">
                        <?php
                            if(isset($_GET['str'])){
                              $str = get_safe_value($con, $_GET['str']);
                            }
                        ?>
                          <input type="search" class="form-control search_text" placeholder="Search..." title="Search by Order ID, Ordered By, Order Status" name="str" value="<?php echo $str ?>" autocomplete="off" required>
                            <button class="btn btn-default search_btn" type="submit">
                              <i class="fa-solid fa-search search_btn_icon"></i>
                            </button>
                            <?php
                              if(isset($_GET['str'])){
                                echo "<a href='order_master.php' class='clear_search_btn'><p>clear</p></a>";
                              }
                            ?>
                        </div>
                      </form>
                    </div>
                  <table class="table datatable">
                    <thead>
                      <tr>
                      <th>Order ID</th>
                      <th>Order Date</th>
                      <th>Ordered By</th>
                      <th>Address</th>
                      <th>Payment Type</th>
                      <th>Payment Status</th>
                      <th>Order Status</th>
                      <th id="th_view_details">Details</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php  
                                    $per_page_records = 5;
                                    $page = 0;
                                    $current_page = 1;
                                    if(isset($_GET['page'])){
                                    $page = $_GET['page'];
                                    if(strpos($page,".") !== false || is_numeric($page) === false){
                                       ?>
                                       <script>
                                       window.location.href="order_master.php";
                                       </script>
                                       <?php
                                       die();
                                    }
                                    if($page<=0){
                                    $page = 0;
                                    $current_page = 1;
                                    }
                                    else{
                                       $current_page = $page;
                                       $page--;
                                       $page = $page * $per_page_records;
                                    }

                                    }

                                    if(isset($_GET['str'])){
                                       $str = mysqli_real_escape_string($con, $_GET['str']);

                                       $total_records = mysqli_num_rows(mysqli_query($con, "select orders.*, order_status.name as order_status_str, users.name as user_name, users.mobile, users.email from orders, order_status, users where (users.name like '%$str%' or orders.id = '$str' or order_status.name like '%$str%') and order_status.id = orders.order_status and users.id = orders.user_id order by orders.id"));
                                       $total_page = ceil($total_records/$per_page_records);
   
                                        $res = mysqli_query($con, "select orders.*, order_status.name as order_status_str, users.name as user_name, users.mobile, users.email from orders, order_status, users where (users.name like '%$str%' or orders.id = '$str' or order_status.name like '%$str%') and order_status.id = orders.order_status and users.id = orders.user_id order by orders.id limit $page, $per_page_records");
                                    }

                                    else{
                                       $total_records = mysqli_num_rows(mysqli_query($con, "select orders.*, order_status.name as order_status_str, users.name as user_name, users.mobile, users.email from orders, order_status, users where order_status.id = orders.order_status and users.id = orders.user_id order by orders.id"));
                                       $total_page = ceil($total_records/$per_page_records);
   
                                        $res = mysqli_query($con, "select orders.*, order_status.name as order_status_str, users.name as user_name, users.mobile, users.email from orders, order_status, users where order_status.id = orders.order_status and users.id = orders.user_id order by orders.id limit $page, $per_page_records");
                                    }

                                    if(!$res){
                                      ?>
                                         <script>
                                         window.location.href="order_master.php";
                                         </script>
                                      <?php
                                      die();
                                      }
                                    
                                     if(mysqli_num_rows($res)>0){
                                     while($row = mysqli_fetch_assoc($res)){
                                     ?>
                                    <tr class="order_master_tr">
                                       <td><?php echo $row['id'] ?></td>
                                       <td><?php echo $row['added_on'] ?></td>
                                       <td><?php echo $row['user_name'] ?></td>
                                       <td class="user_ordered_address"><?php echo ucfirst($row['house_no']) ?>, <?php echo $row['street_address'] ?>, <?php echo $row['city'] ?>, <?php echo $row['state'] ?>, <?php echo $row['pincode'] ?></td>
                                       <td id="td_payment_type"><?php echo $row['payment_type'] ?></td>
                                       <td>
                                        <?php
                                        if($row['payment_status']=='pending'){
                                          echo "Pending";
                                        }
                                        elseif($row['payment_status']=='failure'){
                                          echo "Failed";
                                        }
                                        else if($row['payment_status']=='success'){
                                          echo "Complete";
                                        }
                                        ?>
                                      </td>
                                       <td><?php echo $row['order_status_str'] ?></td>
                                       <td id="td_view_details"> <a class="action_btn badges bg-lightgreen" href="order_master_details.php?id=<?php echo encrypt_id($row['id']) ?>&form_token=<?php echo $order_master_form_generated_token ?>&previous_page=order_master" target="_blank">View Details</a> &nbsp; </td>
                                    </tr>
                                    <?php } } else{
                                    ?>
                                    <tr class="no_results_found_tr">
                                    <td>No orders found.</td>
                                    </tr>
                                    <?php
                                    }?>
                                 </tbody>
                  </table>

                  <nav aria-label="Page navigation">
                     <ul class="pagination">

                      <?php
                      if(mysqli_num_rows($res)>0){
                      if($current_page>=2){
                      ?>

                      <?php
                      if(isset($_GET['str'])){
                      ?>
                      <li class="page-item"><a class="page-link page-link-prev" href="order_master.php?str=<?php echo $str ?>&page=<?php echo $current_page-1; ?>" aria-label="Previous">PREVIOUS</a></li>
                      <?php } else{?>

                      <li class="page-item"><a class="page-link page-link-prev" href="order_master.php?page=<?php echo $current_page-1; ?>" aria-label="Previous">PREVIOUS</a></li>
                      <?php } ?>

                      <?php } ?>

                      <?php 
                      $links = 3;
                      $last_page_number = $total_page;
                      
                      //Start value
                      if($current_page-$links>0){
                        $start = $current_page-$links;
                      }
                      else{
                         $start = 1;
                      }
                      
                      //End value
                      if($current_page+$links<$last_page_number){
                        $end = $current_page+$links;
                      }
                      else{
                        $end = $last_page_number;
                      }

                      for($i=$start; $i<=$end; $i++){

                      if($current_page==$i){
                      ?>

                      <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $i ?></a></li>

                      <?php
                      }
                      else{
                      ?>

                      <?php
                      if(isset($_GET['str'])){
                      ?>
                      <li class="page-item"><a class="page-link" href="order_master.php?str=<?php echo $str ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php } else{?>

                        <li class="page-item"><a class="page-link" href="order_master.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php } ?>

                      <?php } } ?>

                      <?php
                      if($current_page<$total_page){
                      ?>

                      <?php
                      if(isset($_GET['str'])){
                      ?>
                      <li class="page-item"><a class="page-link page-link-next" href="order_master.php?str=<?php echo $str ?>&page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT</a></li>
                      <?php } else{?>

                      <li class="page-item"><a class="page-link page-link-next" href="order_master.php?page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT</a></li>
                      <?php } ?>

                      <?php } }?>

							</ul>
							</nav>

                </div>
            </div>
        </div>
    </div>

<?php require('footer.inc.php'); ?>