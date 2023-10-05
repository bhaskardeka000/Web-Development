<?php
require("connection.inc.php");
require("function.inc.php");
require("paths.inc.php");
$id = get_safe_value($con, $_POST['id']);
$result = mysqli_query($con, "select * from careers where id = '$id'");
$row = mysqli_fetch_assoc($result);

if(!isset($_POST['career_resume_form_token']) || !isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['career_resume_form']) || !isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token']['career_resume_form']) || ($_POST['career_resume_form_token'] !== $_SESSION['csrf_token']['career_resume_form'])){
    ?>
      <script>
      alert("Error occured: Multiple tabs are open/token expired/invalid token.");
      window.location.href = "careers.php";
      </script>
      <?php
      die();
}
else if(mysqli_num_rows($result)<1 || strpos($id,".") !== false || is_numeric($id) === false){
    $_SESSION['Message_error'] = 'Invalid career application ID.';
    ?>
    <script>
    window.location.href = "careers.php";
    </script>
    <?php
    die();
}
$position = strpos($row['resume'], ".");
$type = substr($row['resume'], $position+1);
if($type==='pdf'){
    session_regenerate_id(true);
    header('Location:'.CAREER_FILES_SITE_PATH.$row["resume"]);
    die();
}
else{
    session_regenerate_id(true);
    header('Location: http://docs.google.com/gview?url='.CAREER_FILES_SITE_PATH.$row["resume"].'&embedded=true');
    die();
}
?>