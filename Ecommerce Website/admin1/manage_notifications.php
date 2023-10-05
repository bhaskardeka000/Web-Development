<?php
require('top.inc.php');
$msg_error="";
if(isset($_POST['submit'])){
      if(!isset($_POST['manage_notifications_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['manage_notifications_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['manage_notifications_form']) || ($_POST['manage_notifications_form_token'] !== $_SESSION['csrf_token']['manage_notifications_form'])){
            ?>
            <script>
            alert("Error occured: Multiple tabs are open/token expired/invalid token.");
            window.location.href = "manage_notifications.php";
            </script>
            <?php
            die();
      }

$user_select = get_safe_value($con, $_POST['user_select']);
$enter_user_id = get_safe_value($con, $_POST['enter_user_id']);
$subject = get_safe_value($con, $_POST['subject']);
$message = get_safe_value($con, $_POST['message']);
$status = 0;
$added_on = date('Y-m-d h:i:s');
$notification_common_id = rand(11111, 99999);

$subject = preg_replace('/\s+/', ' ', $subject);
$message = preg_replace('/\s+/', ' ', $message);

$res = mysqli_query($con, "select id, name from users where id = '$enter_user_id'");
$user_id_check = mysqli_num_rows($res);

if($user_select=='' || $subject=='' || $message==''){
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
else if($user_select!='All Users' && $user_select!='One User'){
      // $msg_error = '2';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'Invalid user.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
}
else if($user_select=='All Users' && $enter_user_id!=''){
      // $msg_error = '2';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'User ID is not required for all users.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
}
else if($user_select=='One User' && $enter_user_id==''){
      // $msg_error = '2';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'User ID is required for one user.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
}
else if($user_select=='One User' && $enter_user_id!='' && $user_id_check<1){
      // $msg_error = '1';
      $msg_error = "Yes";
      $_SESSION['Message_error'] = 'No user ID found for ID: '.$enter_user_id.'. Please enter valid user ID.';
      // unset($_SESSION['csrf_token']);
      ?>
      <script>
      window.location.href = window.location.href;
      </script>
      <?php
      die();
}

if($msg_error==''){
      if($user_select=='All Users' && $enter_user_id==''){
      $res = mysqli_query($con, "select id from users");
      while($row = mysqli_fetch_assoc($res)){
            $user_id = $row['id'];
            $user = "All";
            mysqli_query($con, "insert into notifications(notification_common_id, user, user_id, subject, message, status, added_on) values('$notification_common_id', '$user', '$user_id', '$subject', '$message', '$status', '$added_on')");
            unset($_SESSION['last_generated_token_time']['manage_notifications_form']);
            unset($_SESSION['csrf_token']['manage_notifications_form']);
            session_regenerate_id(true);
            $_SESSION['Message_success'] = 'Notification sent successfully.';
      }
      ?>
      <script>
      window.location.href = "notifications.php";
      </script>
      <?php
      die();
      }

      else if($user_select=='One User' && $enter_user_id!=''){
      $res = mysqli_query($con, "select id, name from users where id = '$enter_user_id'");
      $row = mysqli_fetch_assoc($res);
      $user_id = $row['id'];
      $user = $row['name'];
      mysqli_query($con, "insert into notifications(notification_common_id, user, user_id, subject, message, status, added_on) values('$notification_common_id', '$user', '$user_id', '$subject', '$message', '$status', '$added_on')");
      unset($_SESSION['last_generated_token_time']['manage_notifications_form']);
      unset($_SESSION['csrf_token']['manage_notifications_form']);
      session_regenerate_id(true);
      $_SESSION['Message_success'] = 'Notification sent successfully.';
      ?>
      <script>
      window.location.href = "notifications.php";
      </script>
      <?php
      die();
      }
}
}

if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['manage_notifications_form'])){
      $manage_notifications_form_generated_token = bin2hex(random_bytes(16));
      $_SESSION['csrf_token']['manage_notifications_form'] = $manage_notifications_form_generated_token;
      $_SESSION['last_generated_token_time']['manage_notifications_form'] = time();
    }
    else{
      $interval = 60 * 25;
      if(time() -  $_SESSION['last_generated_token_time']['manage_notifications_form']>= $interval){
          $manage_notifications_form_generated_token = bin2hex(random_bytes(16));
          $_SESSION['csrf_token']['manage_notifications_form'] = $manage_notifications_form_generated_token;
          $_SESSION['last_generated_token_time']['manage_notifications_form'] = time();
      }
      else{
          $manage_notifications_form_generated_token = $_SESSION['csrf_token']['manage_notifications_form'];
      }
    }
?>

<head>
<style>
.nice-select{
      margin-bottom: 15px;
}
</style>
</head>
<div class="content">
        <div class="card mb-0">
            <h4 class="card-title notification_form_heading">Notifications Form</h4>
            <form method="post">
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
                  <input type="hidden" name="manage_notifications_form_token" value="<?php echo $manage_notifications_form_generated_token ?>">
                  <div class="form-group">
                        <label for="notifications" class="notification_form_label"><h6>Send To</h6></label>
                        <select id="user_select" name="user_select" required> 
                              <option value="">Select User</option>
                              <option value="All Users">All Users</option>
                              <option value="One User">One User</option>
                        </select>
                  </div>
                  <div class="row notification_user_id_div" style="display: none;">
                     <div class="col-md-6 form-group">
                           <label for="notifications" class="notification_form_label"><h6>User ID</h6></label>
                           <input type="number" placeholder="Enter user ID" class="form-control" name="enter_user_id" id="enter_user_id" autocomplete="off">
                     </div>
                     <div class="col-md-6 form-group find_user_id_label">
                     <label for="notifications" class="notification_form_label"><h6>Find user ID from <a href='users.php' target="_blank" class="user_master_link">User Master</a></h6></label>
					 </div>
                  </div>

                  <div class="row notification_subject_div">
                     <div class="col-md-12 form-group">
                           <label for="notifications" class="notification_form_label"><h6>Subject</h6></label>
                           <input type="text" placeholder="Write subject" class="form-control" name="subject" autocomplete="off" required>
                     </div>
                  </div>

                  <div class="row notification_message_div">
                     <div class="col-md-12 form-group">
                           <label for="notifications" class="notification_form_label"><h6>Message</h6></label>
                           <textarea placeholder="Write Message" class="form-control" name="message" required></textarea>
                     </div>
                  </div>

                  <button type="submit" name="submit" id="notification_form_btn"><span>SEND NOTIFICATION</span></button>
               </div>
            </form>
        </div>
    </div>

<?php require('footer.inc.php'); ?>