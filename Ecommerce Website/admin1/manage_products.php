<?php
require('top.inc.php');
$msg_error="";
$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$image_required = 'required';
$button_name = "ADD";
if(isset($_GET['id']) && $_GET['id']!=''){
   $button_name = "UPDATE";
   $image_required = '';
   $id = get_safe_value($con, $_GET['id']);
   $id = decrypt_id($id);
   $res = mysqli_query($con, "select * from products where id='$id'");
   $check = mysqli_num_rows($res);
   if($check<1){
      // $msg_error = '3';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'Product edit not allowed because the product does not exist.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = "products.php";
      </script>
      <?php
      die();
   }
   else if($_SESSION['previous_products_page_url']=='' && $_GET['id']!=''){
      // $msg_error = '3';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'Direct product editing is not allowed by changing URL. Click on edit to edit a product.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = "products.php";
      </script>
      <?php
      die();
   }
   $row = mysqli_fetch_assoc($res);
   $categories_id = $row['categories_id'];
   $name = $row['name'];
   $mrp = $row['mrp'];
   $price = $row['price'];
   $qty = $row['qty'];
   $image = $row['image'];
   $short_desc = $row['short_desc'];
   $description = $row['description'];
   $meta_title = $row['meta_title'];
   $meta_desc = $row['meta_desc'];
   $meta_keyword = $row['meta_keyword'];
   $preview_image = '1';
   }

if(isset($_POST['submit'])){
   if(!isset($_POST['manage_products_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['manage_products_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['manage_products_form']) || ($_POST['manage_products_form_token'] !== $_SESSION['csrf_token']['manage_products_form'])){
      ?>
      <script>
      alert("Error occured: Multiple tabs are open/token expired/invalid token.");
      window.location.href = "manage_products.php";
      </script>
      <?php
      die();
   }

   $categories_id = get_safe_value($con, $_POST['categories_id']);
   $categories_id = decrypt_id($categories_id);
   $name = get_safe_value($con, $_POST['name']);
   $mrp = get_safe_value($con, $_POST['mrp']);
   $price = get_safe_value($con, $_POST['price']);
   $qty = get_safe_value($con, $_POST['qty']);
   $short_desc = get_safe_value($con, $_POST['short_desc']);
   $description = get_safe_value($con, $_POST['description']);
   $meta_title = get_safe_value($con, $_POST['meta_title']);
   $meta_desc = get_safe_value($con, $_POST['meta_desc']);
   $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);

   $name = preg_replace('/\s+/', ' ', $name);
   $mrp = preg_replace('/\s+/', '', $mrp);
   $price = preg_replace('/\s+/', '', $price);
   $qty = preg_replace('/\s+/', '', $qty);
   $short_desc = preg_replace('/\s+/', ' ', $short_desc);
   $description = preg_replace('/\s+/', ' ', $description);
   $meta_title = preg_replace('/\s+/', ' ', $meta_title);
   $meta_desc = preg_replace('/\s+/', ' ', $meta_desc);
   $meta_keyword = preg_replace('/\s+/', ' ', $meta_keyword);
   $allowed_categories_check = mysqli_query($con, "select * from categories where id='$categories_id' and status = 1");
   
   if($id=='' && ($categories_id=='' || $name=='' || $mrp=='' || $price=='' || $qty=='' || $short_desc=='' || $description=='' || $_FILES['image']['name']=='' || $_FILES['image']['type']=='' || $_FILES['image']['error']=='' || $_FILES['image']['tmp_name']=='' || $_FILES['image']['size']=='')){
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
   else if($id!='' && ($categories_id=='' || $name=='' || $mrp=='' || $price=='' || $qty=='' || $short_desc=='' || $description=='')){
         // $msg_error = '3';
         $msg_error = "Yes";
         $_SESSION['Message_error'] = 'All fields are required. Only image field is optional.';
         // unset($_SESSION['csrf_token']);
         ?>
         <script>
         window.location.href = window.location.href;
         </script>
         <?php
         die();
   }

   else if(!preg_match('/^([0-9]*)$/', $mrp) || !preg_match('/^([0-9]*)$/', $price) || $mrp<0 || $price<0){
      // $msg_error = '7';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'MRP and Price can only be a number and value cannot be less than 0.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
   }

   else if(!preg_match('/^([0-9]*)$/', $qty) || $qty<1){
      // $msg_error = '7';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'Qty can only be a number and value cannot be less than 1.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
   }

   else if(mysqli_num_rows($allowed_categories_check)<1){
      // $msg_error = '6';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'Invalid category.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
   }

   $res = mysqli_query($con, "select * from products where name='$name'");
   $check = mysqli_num_rows($res);
   if($check>0){
      if(isset($_GET['id']) && $_GET['id']!=''){
      $getData = mysqli_fetch_assoc($res);
      if($id == $getData['id']){
      
      }
      else{
         // $msg_error = '4';
         $msg_error = "Yes";
         $_SESSION['Message_error'] = 'Product already exists. Please check product name once.';
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
         // $msg_error = '4';
         $msg_error = "Yes";
         $_SESSION['Message_error'] = 'Product already exists. Please check product name once.';
         // unset($_SESSION['csrf_token']);
         ?>
         <script>
         window.location.href = window.location.href;
         </script>
         <?php
         die();
      }
   }

   if(isset($_GET['id']) && $_GET['id']==0){
      if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
         // $msg_error = '5';
         $msg_error = "Yes";
         $_SESSION['Message_error'] = 'Please select only jpg, jpeg or png type image.';
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
         if($_FILES['image']['type']!=''){
            if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
               // $msg_error = '5';
               $msg_error = "Yes";
               $_SESSION['Message_error'] = 'Please select only jpg, jpeg or png type image.';
               // unset($_SESSION['csrf_token']);
               ?>
               <script>
               window.location.href = window.location.href;
               </script>
               <?php
               die();
            }
         }
      }
            
            
   if($msg_error==''){
      if(isset($_GET['id']) && $_GET['id']!=''){
         if($_FILES['image']['name']!=''){         //If we select an image during update/edit.

            $remove_old_image_from_folder = mysqli_fetch_assoc(mysqli_query($con, "select * from products where id='$id' "));
            unlink(PRODUCT_IMAGE_SERVER_PATH.$remove_old_image_from_folder['image']);  //First we remove old image

            $unique_id = uniqid(mt_rand(), true);
            $unique_id = str_replace(".", "", $unique_id);
            $image = $unique_id.'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image); //Now we insert new image
            $update_query = "update products set categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', image='$image', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword' where id='$id'";
            
         }
         else{
            $update_query = "update products set categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword' where id='$id'";
         }
         mysqli_query($con, $update_query);
         unset($_SESSION['last_generated_token_time']['manage_products_form']);
         unset($_SESSION['csrf_token']['manage_products_form']);
         session_regenerate_id(true);
         $_SESSION['Message_success'] = 'Product updated successfully.';
         ?>
         <script>
            window.location.href = "<?php echo $_SESSION['previous_products_page_url'] ?>";
         </script>
          <?php
         die();
      }
      else{
         $unique_id = uniqid(mt_rand(), true);
         $unique_id = str_replace(".", "", $unique_id);
         $image = $unique_id.'_'.$_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);
         mysqli_query($con, "insert into products(categories_id, name, mrp, price, qty, image, short_desc, description, meta_title, meta_desc, meta_keyword, status) values('$categories_id', '$name', '$mrp', '$price','$qty', '$image', '$short_desc', '$description', '$meta_title', '$meta_desc', '$meta_keyword', '1')" );
         unset($_SESSION['last_generated_token_time']['manage_products_form']);
         unset($_SESSION['csrf_token']['manage_products_form']);
         session_regenerate_id(true);
         $_SESSION['Message_success'] = 'Product inserted successfully.';
         ?>
         <script>
            window.location.href = "products.php";
         </script>
          <?php
         die();
      }
      }
   }

   if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['manage_products_form'])){
      $manage_products_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['manage_products_form'] = $manage_products_form_generated_token;
      $_SESSION['last_generated_token_time']['manage_products_form'] = time();
    }
    else{
      $interval = 60 * 25;
      if(time() -  $_SESSION['last_generated_token_time']['manage_products_form']>= $interval){
          $manage_products_form_generated_token = bin2hex(random_bytes(16));
          $_SESSION['csrf_token']['manage_products_form'] = $manage_products_form_generated_token;
          $_SESSION['last_generated_token_time']['manage_products_form'] = time();
      }
      else{
          $manage_products_form_generated_token = $_SESSION['csrf_token']['manage_products_form'];
      }
    }
?>

<div class="content">
        <div class="card mb-0">
            <h4 class="card-title product_form_heading">Products Form</h4>
            <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="manage_products_form_token" value="<?php echo $manage_products_form_generated_token ?>">
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
                        <label for="products" class="product_form_label"><h6>Category</h6></label>
                        <select name="categories_id"> 
                           <option disabled>Select Category</option>
                           <?php 
                           $res = mysqli_query($con, "select id,categories from categories where status = 1 order by categories asc");
                           while($row = mysqli_fetch_assoc($res)){
                              if($row['id'] == $categories_id){
                                 echo "<option selected value=".encrypt_id($row['id']).">".$row['categories']."</option>";
                              }
                              else{
                                 echo "<option value=".encrypt_id($row['id']).">".$row['categories']."</option>";
                              }
                           
                           }
                           ?>
                        </select>
                  </div>
                  <br>
                  <div class="row product_name_mrp_price_div">
                     <div class="col-md-12 form-group">
                           <label for="products" class="product_form_label"><h6>Product Name</h6></label>
                           <input type="text" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name ?>">    
                     </div>
                  </div>

                  <div class="row common_product_row_div">
                  <div class="col-md-4 form-group">
                           <label for="products" class="product_form_label"><h6>MRP</h6></label>
                           <input type="number" name="mrp" placeholder="Enter product MRP" class="form-control" required value="<?php echo $mrp ?>">
                     </div>
                     <div class="col-md-4 form-group manage_products_price_div">
                           <label for="products" class="product_form_label"><h6>Price</h6></label>
                           <input type="number" name="price" placeholder="Enter product price" class="form-control" required value="<?php echo $price ?>">
                     </div>
                     <div class="col-md-4 form-group manage_products_qty_div">
                           <label for="products" class="product_form_label"><h6>Quantity</h6></label>
                           <input type="number" name="qty" placeholder="Enter product quantity" class="form-control" required value="<?php echo $qty ?>">
                     </div>
                  </div>

                  <div class="row common_product_row_div">
                     <div class="col-md-6 form-group">
                           <label for="products" class="product_form_label"><h6>Short Description</h6></label>
                           <textarea name="short_desc" placeholder="Enter product short description" class="form-control" required><?php echo $short_desc ?></textarea>
                     </div>
                     <div class="col-md-6 form-group manage_products_product_description_div">
                           <label for="products" class="product_form_label"><h6>Product Description</h6></label>
                           <textarea name="description" placeholder="Enter product description" class="form-control" required><?php echo $description ?></textarea>
                     </div>
                  </div>

                  <div class="row common_product_row_div">
                     <div class="col-md-4 form-group">
                           <label for="products" class="product_form_label"><h6>Meta Title(Optional)</h6></label>
                           <textarea name="meta_title" placeholder="Enter product meta title" class="form-control" ><?php echo $meta_title ?></textarea>
                     </div>
                     <div class="col-md-4 form-group manage_products_meta_description_div">
                           <label for="products" class="product_form_label"><h6>Meta Description(Optional)</h6></label>
                           <textarea name="meta_desc" placeholder="Enter product meta description" class="form-control" ><?php echo $meta_desc ?></textarea>
                     </div>
                     <div class="col-md-4 form-group manage_products_meta_keyword_div">
                           <label for="products" class="product_form_label"><h6>Meta Keyword(Optional)</h6></label>
                           <textarea name="meta_keyword" placeholder="Enter product meta keyword" class="form-control"><?php echo $meta_keyword ?></textarea>
                     </div>
                  </div>

                  <div class="row common_product_row_div">
                     <div class="col-md-6 form-group">
                           <label for="products" class="product_form_label "><h6>Image</h6></label>
                           <div class="image_upload_form">
                              <div class="preview">
                                 <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image ?>" id="upload_image_file_preview">
                              </div>
                              <label for="upload_image_file">Upload Image</label>
                              <input type="file" name="image" accept=".jpg, .png, .jpeg" id="upload_image_file" onchange="showPreview(event)" <?php echo $image_required ?>>
                           </div>
                     </div>
                  </div>

                  <button type="submit" name="submit" id="product_form_btn"><span><?php echo $button_name ?></span></button>
               </div>
            </form>
        </div>
    </div>

<?php
require('footer.inc.php');
if($preview_image=='1'){
   ?>
   <script>
   var preview = document.getElementById("upload_image_file_preview");
   preview.style.display = "block";
   </script>
   <?php
}
?>