<?php
session_start();
include('database.inc.php');
$msg="";
$Name="";
$Type="";
$Status="";
$Size="";
$Description="";
$Address="";
$Location="";
$imageerror="";
$image_required='required';
$id="";

if(!isset($_SESSION['IS_LOGIN'])){
    header('Location:index1.php');
}

if( isset($_GET['id']) && $_GET['id']>0 ){
    $id=$_GET['id'];
    $row = mysqli_fetch_assoc(mysqli_query($con,"select * from property where No='$id' "));
    $Name = $row['Name'];
    $Type = $row['Type'];
    $Status = $row['Status'];
    $Size = $row['Size'];
    $Cost = $row['Cost'];
    $Rooms = $row['Rooms'];
    $Description = $row['Description'];
    $Address = $row['Address'];
    $Location = $row['Location'];
    $Image = $row['image'];
    $image_required ='';
    }

    if(isset($_POST['submit'])){
        $Name = $_POST['PName'];
        $Type = $_POST['PType'];
        $Status = $_POST['PStatus'];
        $Added_On = date('Y-m-d');
        $Size = $_POST['PSize'];
        $Cost = $_POST['PCost'];
        $Rooms = $_POST['PRooms'];
        $Description = $_POST['PDescription'];
        $Address = $_POST['PAddress'];
        $Location = $_POST['PLocation'];

    if($id==''){
        $sql = "select * from property where Name='$Name'";
    }else{
        $sql = "select * from property where Name='$Name' and No!='$id' ";
    }    

    if(mysqli_num_rows(mysqli_query($con,$sql))>0){
        $msg="Property already exists";
    }
    else{
        $imagetype = $_FILES['File']['type'];
         if($id=='') {
    
                if($imagetype!='image/jpg' && $imagetype!='image/png' && $imagetype!='image/jpeg'){
                    $imageerror = "Invalid image format";
                }
                else{
                    $server_image = "image/properties/";           //path to store the image.
                    $Image = rand(111111111,999999999).'_'.$_FILES['File']['name'];
                    move_uploaded_file($_FILES['File']['tmp_name'], $server_image.$Image);
                    $sql = "INSERT INTO property(Name,Type,Status,Added_on,Size,Cost,Rooms,Description,image,Address,Location) values('$Name','$Type','$Status','$Added_On','$Size','$Cost','$Rooms','$Description','$Image','$Address','$Location')";
                    mysqli_query($con,$sql);
                    header('Location:manage_property2.php');
                     }
        }
         else {

        if($_FILES['File']['name']!='')
        {
            if($imagetype!='image/jpg' && $imagetype!='image/png' && $imagetype!='image/jpeg'){
                $imageerror = "Invalid image format";
            }
            else{
                $server_image = "image/properties/";        //path to store the image.
                $Image = rand(111111111,999999999).'_'.$_FILES['File']['name'];     
                move_uploaded_file($_FILES['File']['tmp_name'],$server_image.$Image);
            }
        }
        if($imageerror==''){
        $sql = "UPDATE property SET Name='$Name', Type='$Type', Status='$Status', Added_on='$Added_On', Size='$Size', Cost='$Cost', Rooms='$Rooms', Description='$Description', image='$Image', Address='$Address', Location='$Location' where No='$id' ";
        mysqli_query($con,$sql); 
        header('Location:manage_property2.php');
        } 
    }

      
}
    }

?>

<?php include('top1.php'); ?>
<div class="wbg6">
</div>
<div class="new_property_main_div">
<h1 id="new_property_head">Add/Edit Property</h1>
<hr id="add_edit_property_hr">
<div class="property_update_class">
    <hr id="form_hr1">
<form method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Name" id="property_update_input_name" name="PName" value="<?php echo $Name?>" required><br>
    <span style="color:red"><?php echo $msg;?></span>  <br>
    <input type="text" placeholder="Type" id="property_update_input" name="PType" value="<?php echo $Type?>" required> <br>
    <input type="text" placeholder="Status" id="property_update_input" name="PStatus" value="<?php echo $Status?>" required> <br>
    <input type="text" placeholder="Size" id="property_update_input" name="PSize" value="<?php echo $Size?>" required> <br>
    <input type="number" placeholder="Cost" id="property_update_input" name="PCost" value="<?php echo $Cost?>" required> <br>
    <input type="number" placeholder="Rooms" id="property_update_input" name="PRooms" value="<?php echo $Rooms?>" required> <br>
    <input type="text" placeholder="Description" id="property_update_input" name="PDescription" value="<?php echo $Description?>" required> <br>
    <input type="text" placeholder="Address" id="property_update_input" name="PAddress" value="<?php echo $Address?>" required> <br>
    <input type="text" placeholder="Location" id="property_update_input" name="PLocation" value="<?php echo $Location?>" required> <br>
    <input type="file" placeholder="Image" id="property_update_input_image" name="File" <?php echo $image_required ?>> <br>
    <span style="color:red;"><?php echo $imageerror?> </span><br><br>
    <button type="submit" name="submit" id="property_update_submit">SUBMIT</button>

</form>
</div>
</div>
<?php include('footer1.php');?>