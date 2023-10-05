<?php
session_start();
echo $_SESSION['secretkeyhex'];
?>

<script>
  var i = 0;
var a = (function() {
  var tt = setInterval(function() {
    i = i + 1;
    var counter = 6 - i;
   document.getElementById("p_tag").innerHTML = 'You Will Be Redirect After:' + counter;
    if (counter === 0) {
      clearInterval(tt);
      window.location = "www.google.com";
    }
  }, 1000);
})();
a();
</script>
<p id="p_tag"></p>

<?php
// echo datetime();
$date = date('H:i:s Y-m-d');
echo "[".$date."] End of message."
?>



<?php
require('connection.inc.php');

function check_unique_id($con, $id, $query){
  if($query == "Query1"){
    $sql_query = "select * from sodium";
    $column = "order_id";
  }
  $res = mysqli_query($con, $sql_query);
  while($row = mysqli_fetch_assoc($res)){
    if($row[$column] == $id){
      $id_exists = true;
      break;
    }
    else{
      $id_exists = false;
    }
  }
  return $id_exists;
}

function generate_unique_id($con, $query){
  $unique_id = uniqid('', true);
  $check_unique_id = check_unique_id($con, $unique_id, $query);
  while($check_unique_id == true){
    $unique_id = uniqid('', true);
    $check_unique_id = check_unique_id($con, $unique_id, $query);
  }
  return $unique_id;
}
$id = generate_unique_id($con, "Query1");
$id = str_replace(".", "", $id);
$id = strtoupper($id);
mysqli_query($con, "insert into sodium(encrypted_text, secretkey_hex, order_id) values('', '', '$id')");
echo $id;
// checkID
// generateID
?>