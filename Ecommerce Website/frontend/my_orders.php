<?php
require('top.php');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if(!isset($_SESSION['USER_LOGIN'])){
?>
<script>
window.location.href="login.php";
</script>
<?php
die();
}
?>

<head>
    <style>
      table td{
    padding-top: 3rem;
    padding-bottom: 3rem;
    vertical-align: middle;
      }
      .view-order-btn{
    padding-top: 0.55rem;
    padding-bottom: 0.55rem;
    /* font-size: 1.3rem; */
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-weight: 400;
    /* font-size: 1.4rem; */
    line-height: 1.5;
    letter-spacing: -0.01em;
    min-width: 170px;
    border-radius: 0;
    white-space: normal;
    transition: all 0.3s;
    /* color: #85004b; */
    background-color: transparent;
    background-image: none;
    /* border-color: #85004b; */
    box-shadow: none;
    width: 75%;
    border: 1px solid;
    font-size: 14px;
    text-decoration: none;
      }
      .view-order-btn:hover{
      background-color: #85004b;
      color: white;
      cursor: pointer;
      }
      .table-responsive-md{
        margin: 0 1%; margin-bottom: 7%;
    }
table {
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  padding: .35em;
}

table th,
table td {
  /* padding: .625em; */
  text-align: center;
  text-align: left;
}

table th {
  font-size: 19px;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
    background-color: #f8f8f8;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }
  .view-order-btn{
    width: 0;
    min-width: 105px;
    padding-top: 3px;
    padding-bottom: 3px;
}
.table-responsive-md{
    margin: 0;
}
tr{
    border: 1px solid #dbdbdb;
    border-radius: 5px;
}
}

    </style>
</head>

            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">My Orders</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="my_orders.php">My Orders</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            

        <div class="container">
            <div class="row">
                <div class="table-responsive-md" style="margin-bottom: 3%;">
                    <table>
                      <thead style="border-bottom: 1px solid #e0e0e0;">
                        <tr>
                          <th scope="col" style="padding-left: 0; padding-right: 0; padding-top: 1.4rem; padding-bottom: 15px; font-size: 16px; font-weight: 400; line-height: 1.5; color: #999;">Order ID</th>
                          <th scope="col" style="padding-left: 0; padding-right: 0; padding-top: 1.4rem; padding-bottom: 15px; font-size: 16px; font-weight: 400; line-height: 1.5; color: #999;">Price</th>
                          <th scope="col" style="padding-left: 0; padding-right: 0; padding-top: 1.4rem; padding-bottom: 15px; font-size: 16px; font-weight: 400; line-height: 1.5; color: #999;">Order Date</th>
                          <th scope="col" style="padding-left: 0; padding-right: 0; padding-top: 1.4rem; padding-bottom: 15px; font-size: 16px; font-weight: 400; line-height: 1.5; color: #999;">View</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $uid = $_SESSION['USER_ID'];

                          $per_page_records = 5;
                          $page = 0;
                          $current_page = 1;
                          if(isset($_GET['page'])){
                            $page = $_GET['page'];
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
                          $total_records = mysqli_num_rows(mysqli_query($con, "select orders.*, order_status.name as order_status_str from orders, order_status where orders.user_id = '$uid' and order_status.id = orders.order_status"));
                          $total_page = ceil($total_records/$per_page_records);


                          $res = mysqli_query($con, "select orders.*, order_status.name as order_status_str from orders, order_status where orders.user_id = '$uid' and order_status.id = orders.order_status limit $page, $per_page_records");
                          if(!$res){
                          ?>
                          <script>
                          window.location.href="my_orders.php";
                          </script>
                          <?php
                          }

                          if(mysqli_num_rows($res)>0){
                          while($row = mysqli_fetch_assoc($res)){
                        ?>
                        <tr style="border-bottom: 1px solid #e0e0e0;">
                          <td data-label="Order ID"> 
                            <a style="vertical-align:middle; word-wrap: break-word;">  <?php echo $row['id'] ?> </a>
                          </td>
                          <td data-label="Price">  ₹<?php echo $row['total_price'] ?> </td>
                          <td data-label="Order Date"> <?php echo $row['added_on'] ?> </td>
                          <td data-label="View"><a class="view-order-btn" href="my_orders_view_details.php?id=<?php echo encrypt_id($row['id']) ?>" style="color: #85004b; border-color: #85004b;"  onmouseover="this.style.color='white'"  onmouseout="this.style.color='#85004b'">View Details</a></td>
                        </tr>
                        <?php } } else{
                        ?>
                        <tr>
                        <td>No orders found.</td>
                        </tr>
                        <?php
                        }?>
                      </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="Page navigation">
							    <ul class="pagination flex-wrap">

                      <?php
                      if(mysqli_num_rows($res)>0){
                      if($current_page>=2){
                      ?>
                      <li class="page-item"><a class="page-link page-link-prev" href="my_orders.php?page=<?php echo $current_page-1; ?>" aria-label="Previous" tabindex="-1" aria-disabled="true"><span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>PREVIOUS</a></li>
                      <?php } ?>

                      <?php
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
                      ?>

                      <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $i ?></a></li>

                      <?php
                      }
                      else{
                      ?>

                      <li class="page-item"><a class="page-link" href="my_orders.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>

                      <?php } } ?>

                      <?php
                      if($current_page<$total_page){
                      ?>
                      <li class="page-item"><a class="page-link page-link-next" href="my_orders.php?page=<?php echo $current_page+1; ?>" aria-label="Next">NEXT<span aria-hidden="true"><i class="icon-long-arrow-right"></i></span></a></li>
                      <?php } }?>
                      
							    </ul>
				</nav>
        </div>

<?php
require('footer.php');
?>