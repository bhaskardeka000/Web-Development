<?php
require('top.inc.php');
$categories = '';
$msg_error="";
$button_name = "ADD";
if(isset($_GET['id']) && $_GET['id']!=''){
   $button_name = "UPDATE";
   $id = get_safe_value($con, $_GET['id']);
   $id = decrypt_id($id);
   $res = mysqli_query($con, "select * from categories where id='$id'");
   $check = mysqli_num_rows($res);
   if($check<1){
   // $msg_error = '3';
   $msg_error = "Yes";
    $_SESSION['Message_error'] = 'Category edit not allowed because the category does not exist.';
   //  unset($_SESSION['csrf_token']);
    ?>
    <script>
    window.location.href = "categories.php";
    </script>
    <?php
    die();
   }
   else if($_SESSION['previous_categories_page_url']=='' && $_GET['id']!=''){
      // $msg_error = '3';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'Direct category editing is not allowed by changing URL. Click on edit to edit a category.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = "categories.php";
      </script>
      <?php
      die();
   }
   $row = mysqli_fetch_assoc($res);
   $categories = $row['categories'];
   }

if(isset($_POST['submit'])){
   if(!isset($_POST['manage_categories_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['manage_categories_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['manage_categories_form']) || ($_POST['manage_categories_form_token'] !== $_SESSION['csrf_token']['manage_categories_form'])){
      ?>
      <script>
      alert("Error occured: Multiple tabs are open/token expired/invalid token.");
      window.location.href = "manage_categories.php";
      </script>
      <?php
      die();
   }

   $categories = get_safe_value($con, $_POST['categories']);
   $categories = preg_replace('/\s+/', ' ', $categories);

   if($categories==''){
      // $msg_error = '2';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'All fields are required.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
   }
   $res = mysqli_query($con, "select * from categories where categories='$categories'");
   $check = mysqli_num_rows($res);
   if($check>0){
      if(isset($_GET['id']) && $_GET['id']!=''){
      $getData = mysqli_fetch_assoc($res);
      if($id == $getData['id']){
      
      }
      else{
         // $msg_error = '1';
         $msg_error = "Yes";
         $_SESSION['Message_error'] = 'Category already exists. Please check category name once.';
         // unset($_SESSION['csrf_token']);
         ?>
         <script>
         window.location.href = window.location.href;
         </script>
         <?php
         die();
      }
      }
      else{
         // $msg_error = '1';
         $msg_error = "Yes";
         $_SESSION['Message_error'] = 'Category already exists. Please check category name once.';
         // unset($_SESSION['csrf_token']);
         ?>
         <script>
         window.location.href = window.location.href;
         </script>
         <?php
         die();
      }
   }

   if($msg_error==''){
      if(isset($_GET['id']) && $_GET['id']!=''){
         mysqli_query($con, "update categories set categories='$categories' where id='$id'");
         unset($_SESSION['last_generated_token_time']['manage_categories_form']);
         unset($_SESSION['csrf_token']['manage_categories_form']);
         session_regenerate_id(true);
         $_SESSION['Message_success'] = 'Category updated successfully.';
         ?>
         <script>
         window.location.href = "<?php echo $_SESSION['previous_categories_page_url'] ?>";
         </script>
         <?php
         die();
      }
      else{
         mysqli_query($con, "insert into categories(categories, status) values('$categories', '1')" );
         unset($_SESSION['last_generated_token_time']['manage_categories_form']);
         unset($_SESSION['csrf_token']['manage_categories_form']);
         session_regenerate_id(true);
         $_SESSION['Message_success'] = 'Category inserted successfully.';
         ?>
         <script>
         window.location.href = "categories.php";
         </script>
         <?php
         die();
      }
      }
   }

   if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['manage_categories_form'])){
      $manage_categories_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['manage_categories_form'] = $manage_categories_form_generated_token;
      $_SESSION['last_generated_token_time']['manage_categories_form'] = time();
    }
    else{
      $interval = 60 * 25;
      if(time() -  $_SESSION['last_generated_token_time']['manage_categories_form']>= $interval){
          $manage_categories_form_generated_token = bin2hex(random_bytes(16));
          $_SESSION['csrf_token']['manage_categories_form'] = $manage_categories_form_generated_token;
          $_SESSION['last_generated_token_time']['manage_categories_form'] = time();
      }
      else{
          $manage_categories_form_generated_token = $_SESSION['csrf_token']['manage_categories_form'];
      }
    }
?>

<div class="content">
        <div class="card mb-0">
            <h4 class="card-title category_form_heading">Categories Form</h4>
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
                    <div class="form-group">
                        <form method="post">
                        <label class="category_form_label"><h6>Category</h6></label>
                        <input type="hidden" name="manage_categories_form_token" value="<?php echo $manage_categories_form_generated_token ?>">
                        <input type="text" name="categories" class="form-control" placeholder="Enter category name" required value="<?php echo $categories ?>" autocomplete="off">
                        <button type="submit" name="submit" id="category_form_btn"><span><?php echo $button_name ?></span></button>
                        </form>
                    </div>
            </div>
        </div>
    </div>

<?php require('footer.inc.php'); ?>