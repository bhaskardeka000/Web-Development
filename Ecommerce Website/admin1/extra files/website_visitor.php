<?php
require('connection.inc.php');

$per_page_records = 5;
$page = 0;
$current_page = 1;
$output = '';
if(isset($_POST["page"])){
    $page = $_POST["page"];

    if($page<=0){
        $page = 0;
        $current_page = 1;
        }
        else{
          $current_page = $page;
          $page--;
          $page = $page * $per_page_records;
        }
}

$total_records = mysqli_num_rows(mysqli_query($con, "select * from website_visitors"));
$total_page = ceil($total_records/$per_page_records);

$sql = "select * from website_visitors limit $page, $per_page_records";
$res = mysqli_query($con, $sql);


$output .= '

<div class="table-responsive dataview">
	<table class="table datatable">
		<thead>
			<tr>
				<th>Visitors ID</th>
				<th>IP Address</th>
				<th>Country</th>
				<th>Visiting Date Time</th>
			</tr>
		</thead>
';

if(mysqli_num_rows($res)>0){
    $output .= '
    
		<tbody>
    ';
    while($row = mysqli_fetch_assoc($res)){
    $output .= '
    
			<tr>
				<td>'.ucfirst($row["id"]).'</td>
				<td>'.ucfirst($row["ip_address"]).'</td>
				<td>'.ucfirst($row["country"]).'</td>
				<td>'.ucfirst($row["visiting_date_time"]).'</td>
			</tr>
    ';
    }
    $output .= '
    
		</tbody>
    ';
}
else{
$output .= '

		<tbody>
			<tr>
				<td>No data found</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
';
}
$output .= '

	</table>
</div>
';

$output .= '
<ul class="pagination flex-wrap">';
if($current_page>=2){
    $previous = $current_page-1;
$output .= '
	<li class="paginate_button page-item" id="'.$previous.'">
		<a aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">
			<i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;PREVIOUS
		</a>
	</li>';
}


$links = 3;
$last_page_number = $total_page;

//Start value
if($current_page-$links>0){
  $start = $current_page-$links;
}
else{
   $start = 1;
}

//End value
if($current_page+$links<$last_page_number){
  $end = $current_page+$links;
}
else{
  $end = $last_page_number;
}

for($i=$start; $i<=$end; $i++){

if($current_page==$i){
    $output .= '
	<li class="paginate_button active">
		<a aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">'.$i.'</a>
	</li>';
}
else{
    $output .= '
	<li class="paginate_button page-item" id="'.$i.'">
		<a aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">'.$i.'</a>
	</li>';
}
}   


if($current_page<$total_page){
$current_page = $current_page+1;
    $output .= '
	<li class="paginate_button page-item" id="'.$current_page.'">
		<a aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">
			NEXT&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
		</a>
	</li>';
    }
    $output .=  '
</ul>';
    echo $output;
?>