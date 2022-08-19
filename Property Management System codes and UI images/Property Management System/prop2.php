<?php include('database.inc.php');
$SQL= "select * from property";
$result = mysqli_query($con, $SQL);
?>

<?php include('prop1.php'); ?>
<div class="main">
    <?php if(mysqli_num_rows($result)>0) { 
        while($row = mysqli_fetch_assoc($result)) {
            ?>    
   
    <?php  $site_image_status = "image/properties/";?>
    <div class="gridclass">

        <div class="card">
        <h6 class="card-title"> <?php echo $row['Name'] ?> </h6>

            <div class="card-body">
            <img src="<?php echo $site_image_status.$row['image']?>" width="200" height="200" class="card-image">
            <h6> &#8377; <?php echo $row['Cost'] ?> </h6>
            </div>

            <div class="viewclass">
            <td><a target="_blank" href="prop_details.php?id=<?php echo $row['No']?>" class="details">View Details</a> &nbsp;
            </div>
        </div>
    </div>
    <?php  } }  ?>

</div>