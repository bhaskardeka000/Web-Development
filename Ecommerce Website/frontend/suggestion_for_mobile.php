
    <?php 
require('connection.inc.php'); 
require('function.inc.php'); 
$query = get_safe_value($con, $_POST['query']);

$res = mysqli_query($con, "select products.*, categories.categories from products, categories where products.status = 1 and products.categories_id = categories.id and (products.name like '%$query%' or products.description like '%$query%')");
if(mysqli_num_rows($res)>0){
    echo "<div class='display_search_products' style='border: 0.1rem solid #ebebeb; border-top: none; margin: 0 20px; margin-top: -15px; position: absolute; z-index: 1000; width: 205px; max-height: 200px; overflow-y: scroll;'>";
while($row = mysqli_fetch_assoc($res)){
    echo "<a href='search.php?str=".$row['name']."' class='list-group-item list-group-item-action border-1' style='font-size: 15px; border: none; padding-top: 10px; padding-bottom: 10px;'>".$row['name']."</a>";
}
echo "<a href='search.php?str=".$query."' class='list-group-item list-group-item-action border-1' style='font-size: 15px; border: none; padding-top: 10px; padding-bottom: 10px;'>".$query."</a>";
echo "</div>";
}
else{
    echo "<div class='display_search_products' style='border: 0.1rem solid #ebebeb; border-top: none; margin: 0 20px; margin-top: -15px; position: absolute; z-index: 1000; width: 205px; max-height: 200px; overflow-y: scroll;'>";
    echo "<a href='search.php?str=".$query."' class='list-group-item list-group-item-action border-1' style='font-size: 15px; border: none; padding-top: 10px; padding-bottom: 10px;'>".$query."</a>";
    echo "</div>";
}
?>