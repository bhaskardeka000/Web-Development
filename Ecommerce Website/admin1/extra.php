if($type!='status' && $type!='delete'){
  $_SESSION['Message_error'] = 'Invalid type.';
  ?>
  <script>
  window.location.href = "categories.php";
  </script>
  <?php
  die();
}


if($type=='delete'){
    $id = get_safe_value($con, $_GET['id']);
    $id = decrypt_id($id);
    $delete_sql = "delete from categories where id='$id' ";
    mysqli_query($con, $delete_sql);
    $_SESSION['Message_success'] = 'Category deleted successfully.';
    ?>
    <script>
    window.location.href = "categories.php";
    </script>
    <?php
    die();
    }


  <html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<body>

<button id="postYourAdd" onclick="light()">OPEN</button>
<iframe id="forPostyouradd" src="" title="W3Schools Free Online Web Tutorials" width="100%" height="100%">
</iframe>

<script>
function light() {
    var iframe = $("#forPostyouradd");
    debugger;
    iframe.attr("src", "http://docs.google.com/gview?url=https://scotchclubinternational.com/media/career_files/193538457.docx&embedded=true"); 
}
</script>
</body>
</html>


<a href="http://docs.google.com/gview?url=https://scotchclubinternational.com/media/career_files/193538457.docx&embedded=true" target="_blank">Open</a>
<!-- <iframe src='http://docs.google.com/gview?url=https://scotchclubinternational.com/media/career_files/193538457.docx&embedded=true' frameborder='0' width="100%" height="100%"></iframe> -->

  <?php
require("connection.inc.php");
$row = mysqli_fetch_assoc(mysqli_query($con, "select * from careers where id = 71"));

$string =  $row['resume'];
// $array = explode(' ', $string);
$pos = strpos($string, ".");
$type substr($string, $pos+1);
?>


<?php
if( $_COOKIE['adm_sid'] )
{
    session_id( $_COOKIE['adm_sid'] );
    session_start();
}
print_r($_SESSION);
?>
