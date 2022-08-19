<?php
include('database.inc.php');

if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']>0){
$type = $_GET['type'];
$id = $_GET['id'];

if($type=='delete'){
$sql = "DELETE FROM property where NO='$id'";
mysqli_query($con,$sql);
header('Location:manage_property2.php');   
}   
}

$SQL= "SELECT * FROM property ";
$result = mysqli_query($con, $SQL);
?>

<div class="overall_property_div">
<h1 id="prop_manager_head">Property Manager</h1>
<a href="new_property.php" id="addprop">ADD PROPERTY</a>
    <div class='property_container'>
    <table >
    <tr>
    <th>S.No#</th>
    <th>Name</th>
    <th>Type</th>
    <th>Status</th>
    <th>Added On</th>
    <th>Size</th>
    <th>Cost</th>
    <th>Rooms</th>
    <th>Description</th>
    <th>Image</th>
    <th>Address</th>
    <th>Location</th>
    <th id="actionid">Actions</th>
    </tr>
    <?php if(mysqli_num_rows($result)>0) { 
          $i=1;
          while($row = mysqli_fetch_assoc($result)) {
    ?>    
    <tr>
            <td> <?php echo $i ?> </td>
            <td> <?php echo $row['Name'] ?> </td>
            <td> <?php echo $row['Type'] ?> </td>
            <td> <?php echo $row['Status'] ?> </td>
            <td> <?php echo $row['Added_on'] ?> </td>
            <td> <?php echo $row['Size'] ?> </td>
            <td> <?php echo $row['Cost'] ?> </td>
            <td> <?php echo $row['Rooms'] ?> </td>
            <td> <?php echo $row['Description'] ?> </td>
            <td> 
            <?php  $site_image_status = "image/properties/";?>    
            <a target="_blank" href="<?php echo $site_image_status.$row['image']?>"> 
            <img src="<?php echo $site_image_status.$row['image']?>"  height="54px" width="54px" style="border-radius:5px; "> 
            </a> 
            </td>

            <td> <?php echo $row['Address'] ?> </td>
            <td> <?php echo $row['Location'] ?> </td>
            <td>
            <a href="new_property.php?id=<?php echo $row['No']?>" class="actions1">Edit</a> &nbsp;
            <a href="?id=<?php echo $row['No']?>&type=delete" class="actions3">Delete</a>
            </td>
    </tr>

    <?php $i++; } } else { ?>
    <tr>
   <td colspan="5">No data found</td>
   </tr>
    <?php } ?>
</table>
</div>
    </div>
<?php include('footer1.php');?>