<?php
require('top.inc.php');
$str = "";

if(isset($_POST['category_status_change']) || isset($_POST['category_delete'])){
  if(!isset($_POST['categories_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['categories_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['categories_form']) || ($_POST['categories_form_token'] !== $_SESSION['csrf_token']['categories_form'])){
    ?>
    <script>
    alert("Error occured: Multiple tabs are open/token expired/invalid token.");
    window.location.href = "categories.php";
    </script>
    <?php
    die();
  }

  $id = get_safe_value($con, $_POST['id']);
  $id = decrypt_id($id);
  $allowed_categories_check = mysqli_query($con, "select * from categories where id='$id' ");

  if(mysqli_num_rows($allowed_categories_check)<1){
    $_SESSION['Message_error'] = 'Invalid category ID.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = "<?php echo $_SESSION['previous_categories_page_url'] ?>";
    </script>
    <?php
    die();
  }
}

if(isset($_POST['category_status_change'])){
  $operation = get_safe_value($con, $_POST['operation']);

  if($operation!='active' && $operation!='deactive'){
    $_SESSION['Message_error'] = 'Invalid operation.';
    // unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = "<?php echo $_SESSION['previous_categories_page_url'] ?>";
    </script>
    <?php
    die();
  }

  if($operation=='active'){
    $status = '1';
  }
  else{
    $status = '0';
  }
  $update_status_sql = "update categories set status='$status' where id='$id' ";
  mysqli_query($con, $update_status_sql);
  unset($_SESSION['last_generated_token_time']['categories_form']);
  unset($_SESSION['csrf_token']['categories_form']);
  session_regenerate_id(true);
  $_SESSION['Message_success'] = $operation=='active' ? 'Category activated.' : 'Category deactivated.';
  ?>
  <script>
  window.location.href = "<?php echo $_SESSION['previous_categories_page_url'] ?>";
  </script>
  <?php
  die();
}


if(isset($_POST['category_delete'])){
  $delete_sql = "delete from categories where id='$id' ";
  mysqli_query($con, $delete_sql);
  unset($_SESSION['last_generated_token_time']['categories_form']);
  unset($_SESSION['csrf_token']['categories_form']);
  session_regenerate_id(true);
  $_SESSION['Message_success'] = 'Category deleted successfully.';
  ?>
  <script>
  window.location.href = "categories.php";
  </script>
  <?php
  die();
}



$per_page_records = 5;
$page = 0;
$current_page = 1;
if(isset($_GET['page'])){
  $page = $_GET['page'];
  if(strpos($page,".") !== false || is_numeric($page) === false){
    // unset($_SESSION['csrf_token']);
   ?>
   <script>
   window.location.href="categories.php";
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
   $str = get_safe_value($con, $_GET['str']);

   $total_records = mysqli_num_rows(mysqli_query($con, "select * from categories where categories like '%$str%' or id = '$str' "));
   $total_page = ceil($total_records/$per_page_records);

    $res = mysqli_query($con, "select * from categories where categories like '%$str%' or id = '$str' limit $page, $per_page_records");
}

else{
   $total_records = mysqli_num_rows(mysqli_query($con, "select * from categories"));
   $total_page = ceil($total_records/$per_page_records);
   
   $sql = "select * from categories limit $page, $per_page_records";
   $res = mysqli_query($con, $sql);
}

if(!$res){
  // unset($_SESSION['csrf_token']);
?>
   <script>
   window.location.href="categories.php";
   </script>
<?php
die();
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['categories_form'])){
  $categories_form_generated_token = bin2hex(random_bytes(16));
  $_SESSION['csrf_token']['categories_form'] = $categories_form_generated_token;
  $_SESSION['last_generated_token_time']['categories_form'] = time();
}
else{
  $interval = 60 * 25;
  if(time() -  $_SESSION['last_generated_token_time']['categories_form']>= $interval){
      $categories_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['categories_form'] = $categories_form_generated_token;
      $_SESSION['last_generated_token_time']['categories_form'] = time();
  }
  else{
      $categories_form_generated_token = $_SESSION['csrf_token']['categories_form'];
  }
}
?>

    <div class="content">
        <div class="main_page_heading_div">
          <h3 class="main_heading">Categories</h3>
          <h4 class="card-title insert_heading_h4"><a class="insert_heading_a" href="manage_categories.php">Add Category</a></h4>
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
                      <form action="categories.php" method="get">
                        <div class="input-group">
                        <?php
                            if(isset($_GET['str'])){
                              $str = get_safe_value($con, $_GET['str']);
                            }
                        ?>
                          <input type="search" class="form-control search_text" placeholder="Search..." title="Search by ID, Category" name="str" value="<?php echo $str ?>" autocomplete="off" required>
                            <button class="btn btn-default search_btn" type="submit">
                              <i class="fa-solid fa-search search_btn_icon"></i>
                            </button>
                            <?php
                              if(isset($_GET['str'])){
                                echo "<a href='categories.php' class='clear_search_btn'><p>clear</p></a>";
                              }
                            ?>
                        </div>
                      </form>
                    </div>
                  <table class="table datatable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>category</th>
                        <th id="th_actions">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                                   <?php
                                   if(mysqli_num_rows($res)>0){
                                   while($row = mysqli_fetch_assoc($res)) {?>
                                    <tr>
                                       <td><?php echo $row['id'] ?></td>
                                       <td><?php echo $row['categories'] ?></td>
                                       <td>
                                    <form action="categories.php" method="post">
                                        
                                       <input type="hidden" name="categories_form_token" value="<?php echo $categories_form_generated_token ?>">
                                       <input type="hidden" name="id" value="<?php echo encrypt_id($row['id']) ?>">

                                    <?php 
                                    if($row['status']==1){
                                      $btn_color = "lightgreen";
                                      $status = "Active";
                                      echo"<input type='hidden' name='operation' value='deactive'>";
                                    }
                                    else{
                                      $btn_color = "lightyellow";
                                      $status = "Deactive";
                                      echo"<input type='hidden' name='operation' value='active'>";
                                    }
                                    $_SESSION['previous_categories_page_url'] = "categories.php?page=$current_page";
                                    echo "<button class='badges bg-$btn_color status_change_btn' type='submit' name='category_status_change'><a class='action_btn'>$status</a></button> &nbsp;";
                                    echo "<a class='action_btn badges bg-deepblue' href='manage_categories.php?id=".encrypt_id($row['id'])."'>Edit</a> &nbsp;";
                                    echo "<button class='badges bg-lightred delete_btn' type='submit' name='category_delete' onclick='return check_delete_category()'><a class='action_btn'>Delete</a></button> &nbsp;";
                                       ?>
                                    </form>
                                    </td>
                                    </tr>           
                                    <?php } } else{
                                    ?>
                                    <tr class="no_results_found_tr">
                                    <td>No categories found.</td>
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
                      <li class="page-item"><a class="page-link page-link-prev" href="categories.php?str=<?php echo $str ?>&page=<?php echo $current_page-1; ?>" aria-label="Previous">PREVIOUS</a></li>
                      <?php } else{?>

                      <li class="page-item"><a class="page-link page-link-prev" href="categories.php?page=<?php echo $current_page-1; ?>" aria-label="Previous">PREVIOUS</a></li>
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
                      <li class="page-item"><a class="page-link" href="categories.php?str=<?php echo $str ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php } else{?>

                        <li class="page-item"><a class="page-link" href="categories.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php } ?>

                      <?php } } ?>

                      <?php
                      if($current_page<$total_page){
                      ?>

                      <?php
                      if(isset($_GET['str'])){
                      ?>
                      <li class="page-item"><a class="page-link page-link-next" href="categories.php?str=<?php echo $str ?>&page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT</a></li>
                      <?php } else{?>

                      <li class="page-item"><a class="page-link page-link-next" href="categories.php?page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT</a></li>
                      <?php } ?>

                      <?php } }?>

							</ul>
							</nav>

                </div>
            </div>
        </div>
    </div>


<?php require('footer.inc.php'); ?>