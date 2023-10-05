<?php
require('top.inc.php');
$str = "";

if(isset($_POST['partnership_request_delete'])){
  if(!isset($_POST['partners_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['partners_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['partners_form']) || ($_POST['partners_form_token'] !== $_SESSION['csrf_token']['partners_form'])){
    ?>
    <script>
    alert("Error occured: Multiple tabs are open/token expired/invalid token.");
    window.location.href = "partners.php";
    </script>
    <?php
    die();
  }

$id = get_safe_value($con, $_POST['id']);
$id = decrypt_id($id);
$allowed_partners_check = mysqli_query($con, "select * from partners where id='$id' ");

if(mysqli_num_rows($allowed_partners_check)<1){
  $_SESSION['Message_error'] = 'Invalid partnership request ID.';
  // unset($_SESSION['csrf_token']);
  ?>
  <script>
  window.location.href = "<?php echo $_SESSION['previous_partners_page_url'] ?>";
  </script>
  <?php
  die();
}

$delete_sql = "delete from partners where id='$id' ";
mysqli_query($con, $delete_sql);
unset($_SESSION['last_generated_token_time']['partners_form']);
unset($_SESSION['csrf_token']['partners_form']);
session_regenerate_id(true);
$_SESSION['Message_success'] = 'Partnership request deleted successfully.';
?>
<script>
window.location.href = "partners.php";
</script>
<?php
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['partners_form'])){
  $partners_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['partners_form'] = $partners_form_generated_token;
  $_SESSION['last_generated_token_time']['partners_form'] = time();
}
else{
  $interval = 60 * 25;
  if(time() -  $_SESSION['last_generated_token_time']['partners_form']>= $interval){
      $partners_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['partners_form'] = $partners_form_generated_token;
      $_SESSION['last_generated_token_time']['partners_form'] = time();
  }
  else{
      $partners_form_generated_token = $_SESSION['csrf_token']['partners_form'];
  }
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['partners_details_form'])){
  $partners_details_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['partners_details_form'] = $partners_details_form_generated_token;
  $_SESSION['last_generated_token_time']['partners_details_form'] = time();
}
else{
  $interval = 60 * 25;
  if(time() -  $_SESSION['last_generated_token_time']['partners_details_form']>= $interval){
      $partners_details_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['partners_details_form'] = $partners_details_form_generated_token;
      $_SESSION['last_generated_token_time']['partners_details_form'] = time();
  }
  else{
      $partners_details_form_generated_token = $_SESSION['csrf_token']['partners_details_form'];
  }
}
?>

<div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Partners</h3>
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

                  else if(isset($_SESSION['Message_success'])){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <?php echo $_SESSION['Message_success'] ?>
                          <button type="button" class="btn-close alert_box_close_btn" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                    unset($_SESSION['Message_success']);
                    }
               ?>
                <div class="table-responsive">
                    <div class="col-sm-7 col-md-5 col-lg-4 search_main_div">
                      <form action="partners.php" method="get">
                        <div class="input-group">
                        <?php
                            if(isset($_GET['str'])){
                              $str = get_safe_value($con, $_GET['str']);
                            }
                        ?>
                          <input type="search" class="form-control search_text" placeholder="Search..." title="Search by Request ID, Name" name="str" value="<?php echo $str ?>" autocomplete="off" required>
                            <button class="btn btn-default search_btn" type="submit">
                              <i class="fa-solid fa-search search_btn_icon"></i>
                            </button>
                            <?php
                              if(isset($_GET['str'])){
                                echo "<a href='partners.php' class='clear_search_btn'><p>clear</p></a>";
                              }
                            ?>
                        </div>
                      </form>
                    </div>
                  <table class="table datatable">
                    <thead>
                      <tr>
                      <th>Request ID</th>
                      <th>Name (Individual / Company / Organization / Brand)</th>
                      <th>Applied for</th>
                      <th>Requested On</th>
                      <th id="th_view_details">Details</th>
                      <th id="th_action_delete">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                                    <?php
                                    
                                    $per_page_records = 5;
                                    $page = 0;
                                    $current_page = 1;
                                    if(isset($_GET['page'])){
                                    $page = $_GET['page'];
                                    // $page - floor($page) !=0
                                    if(strpos($page,".") !== false || is_numeric($page) === false){
                                      // unset($_SESSION['csrf_token']);
                                    ?>
                                    <script>
                                    window.location.href="partners.php";
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

                                       $total_records = mysqli_num_rows(mysqli_query($con, "select * from partners where name like '%$str%' or id = '$str' "));
                                       $total_page = ceil($total_records/$per_page_records);
   
                                        $res = mysqli_query($con, "select * from partners where name like '%$str%' or id = '$str' limit $page, $per_page_records");
                                    }
                                    
                                    else{
                                       $total_records = mysqli_num_rows(mysqli_query($con, "select * from partners"));
                                       $total_page = ceil($total_records/$per_page_records);
   
                                        $res = mysqli_query($con, "select * from partners limit $page, $per_page_records");
                                    }

                                    if(!$res){
                                      // unset($_SESSION['csrf_token']);
                                      ?>
                                         <script>
                                         window.location.href="partners.php";
                                         </script>
                                      <?php
                                      die();
                                      }

                                     if(mysqli_num_rows($res)>0){
                                     while($row = mysqli_fetch_assoc($res)){
                                     ?>
                                    <tr class="partners_tr">
                                       <td><?php echo $row['id'] ?></td>
                                       <td><?php echo $row['name'] ?></td>
                                       <td><?php echo $row['applied_for'] ?></td>

                                       <td> <?php echo $row['added_on']?> </td>
                                       <td id="td_view_details"> <a class="action_btn badges bg-lightgreen" href="partners_details.php?id=<?php echo encrypt_id($row['id']) ?>&form_token=<?php echo $partners_details_form_generated_token ?>" target="_blank">View Details</a> &nbsp; </td>
                                       <td>
                                       <form action="partners.php" method="post">
                                       <input type="hidden" name="partners_form_token" value="<?php echo $partners_form_generated_token ?>">
                                       <input type="hidden" name="id" value="<?php echo encrypt_id($row['id']) ?>">

                                       <?php
                                       $_SESSION['previous_partners_page_url'] = "partners.php?page=$current_page";
                                       echo "<button class='badges bg-lightred delete_btn' type='submit' name='partnership_request_delete' onclick='return check_delete_partnership_request()'><a class='action_btn'>Delete</a></button> &nbsp;";
                                       ?>
                                    
                                    </td>
                                    </tr>           
                                    <?php } } else{
                                    ?>
                                    <tr class="no_results_found_tr">
                                    <td>No partnership request found.</td>
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
                      <li class="page-item"><a class="page-link page-link-prev" href="partners.php?str=<?php echo $str ?>&page=<?php echo $current_page-1; ?>" aria-label="Previous">PREVIOUS</a></li>
                      <?php } else{?>

                      <li class="page-item"><a class="page-link page-link-prev" href="partners.php?page=<?php echo $current_page-1; ?>" aria-label="Previous">PREVIOUS</a></li>
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
                      <li class="page-item"><a class="page-link" href="partners.php?str=<?php echo $str ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php } else{?>

                        <li class="page-item"><a class="page-link" href="partners.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php } ?>

                      <?php } } ?>

                      <?php
                      if($current_page<$total_page){
                      ?>

                      <?php
                      if(isset($_GET['str'])){
                      ?>
                      <li class="page-item"><a class="page-link page-link-next" href="partners.php?str=<?php echo $str ?>&page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT</a></li>
                      <?php } else{?>

                      <li class="page-item"><a class="page-link page-link-next" href="partners.php?page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT</a></li>
                      <?php } ?>

                      <?php } }?>

							</ul>
							</nav>


                </div>
            </div>
        </div>
    </div>

<?php require('footer.inc.php'); ?>