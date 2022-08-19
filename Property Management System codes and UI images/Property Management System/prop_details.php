<?php include('top.php');
       include('database.inc.php');

if( isset($_GET['id']) ){
    $pro_id = $_GET['id'];
    $sql = "select * from property where No='$pro_id' ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $Name = $row['Name'];
    $Type = $row['Type'];
    $Status = $row['Status'];
    $Address = $row['Address'];
    $Size = $row['Size'];
    $Cost = $row['Cost'];
    $Rooms = $row['Rooms'];
    $Description = $row['Description'];
    $Location = $row['Location'];
}
?>

<div class="wbg_prop_details">
</div>
<div class="prop_details_main_div">

<div>
<h1 id="prop_details_head1">Property Details</h1>
    <hr id="prop_details_hr1">
<table id="vertical">
<thead id="Thead">
<tr>
    <th id="prop_th">Property Name</th>
</tr>

<tr>
    <th id="prop_th">Property Location</th>
</tr>

<tr>
    <th id="prop_th">Property Address</th>
</tr>

<tr>
    <th id="prop_th">Property Type</th>
</tr>

<tr>
    <th id="prop_th">Property Status</th>
</tr>

<tr>
    <th id="prop_th">Size</th>
</tr>

<tr>
    <th id="prop_th">Cost</th>
</tr>

<tr>
    <th id="prop_th">Rooms</th>
</tr>

<tr>
    <th id="prop_th">Description</th>
</tr>
</thead>
<tbody id="Tbody">

<tr>
    <td id="prop_td"><?php echo $Name?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Location?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Address?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Type?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Status?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Size?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Cost?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Rooms?></td>
</tr>

<tr>
    <td id="prop_td"><?php echo $Description?></td>
</tr>
</tbody>
</table>
</div>
<div id="prop_photo_div">
<h1 id="prop_details_head1">Property Image</h1>
    <hr id="prop_details_hr2">
<?php  $site_image_status = "image/properties/";?>
<img src="<?php echo $site_image_status.$row['image']?>" width="320" height="200"> 
</div>
</div>
<?php include('footer.php'); ?>