<?php  include('database.inc.php');
       include('top.php');
       $SearchLocation = $_POST['LOC'];
       $sql = "SELECT * FROM property where Location='$SearchLocation' ";
       $result = mysqli_query($con,$sql);
?>

<div class="wbg2">
</div>
<h1 class="registered">All Registered Property</h1>
<hr class="hr-prop">
<div class="searchclass">
<form action="search.php" method="post">
    <input type="text" placeholder="Enter Location" id="searchid" name="LOC">
    <button type="submit" id="searchbtn">Search</button>
</form>
</div>

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

    <?php  } }  else{ ?>  
       <h2 class="nodata"><?php echo "No data Found" ?></h2>
    <?php } ?>
        
        </div>

