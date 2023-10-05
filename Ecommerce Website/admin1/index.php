<?php require('top.inc.php');
?>

    <div class="content">
      <div class="main_page_heading_div">
        <h2>Dashboard</h2>
      </div>
        <div class="row">

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count" onclick="location.href='pending_order_master.php'">
                <div class="dash-counts">
                  <?php
                  $pending_order_count = mysqli_fetch_array(mysqli_query($con, "select count(*) from orders where order_status = 1"));
                  ?>
                  <h4><?php echo $pending_order_count[0] ?></h4>
                  <h5>Pending Orders</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="shopping-bag"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count das1" onclick="location.href='users.php'">
                <div class="dash-counts">
                  <?php
                  $user_count = mysqli_fetch_array(mysqli_query($con, "select count(id) from users"));
                  ?>
                  <h4><?php echo $user_count[0] ?></h4>
                  <h5>User Registrations</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="user-plus"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count das2" onclick="location.href='index.php'">
                <div class="dash-counts">
                  <?php 
                  $visitor_count = mysqli_fetch_array(mysqli_query($con, "select count(ip_address) from website_visitors"));
                  ?>
                  <h4><?php echo $visitor_count[0] ?></h4>
                  <h5>Total Unique Visitors</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="pie-chart"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count das3" onclick="location.href='products.php'">
                <div class="dash-counts">
                  <?php
                  $active_product_count = mysqli_fetch_array(mysqli_query($con, "select count(id) from products where status = 1"));
                  ?>
                  <h4><?php echo $active_product_count[0] ?></h4>
                  <h5>Total Active Products</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="package"></i>
                </div>
              </div>
            </div>

            <div class="col-lg-12 col-sm-12 col-12">
              <div class="dash-widget dash1">
                <div class="dash-widgetimg">
                  <span>
                    <img src="assets/img/icons/dash2.svg" alt="img">
                  </span>
                </div>
                <div class="dash-widgetcontent">
                  <?php
                  $total_sales_amount = mysqli_fetch_array(mysqli_query($con, "select sum(orders.total_price) from orders, transactions where orders.id = transactions.order_id and orders.payment_status = 'success' and orders.order_status = 5 and transactions.txnid <> ''"));
                  ?>
                  <h3>₹<span class="counters"><?php echo $total_sales_amount[0] ?></span>
                  </h3>
                  <h5>Total Sales Amount</h5>
                </div>
              </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <h4 class="card-title website_visitor_heading">Website Visitors</h4>
                <div class="table-responsive">
                  <table class="table datatable website_visitor_table" style="border-left: 1px solid #e9ecef; border-right: 1px solid #e9ecef;">
                    <thead>
                      <tr style="border: none;">
                        <th style="border-bottom: 1px solid #e9ecef;">Visitors ID</th>
                        <th style="border-bottom: 1px solid #e9ecef;">IP Address</th>
                        <th style="border-bottom: 1px solid #e9ecef;">Country</th>
                        <th style="border-bottom: 1px solid #e9ecef;">Visiting Data and Time</th>
                      </tr>
                    </thead>
                      <tbody>
                      <?php
                      $res = mysqli_query($con, "select * from website_visitors");
                      if(mysqli_num_rows($res)>0){
                      while($row = mysqli_fetch_assoc($res)){
                      ?>
                          <tr style="border: none;">
                          <td style="border-bottom: 1px solid #e9ecef;"><?php echo $row['id'] ?></td>
                          <td style="border-bottom: 1px solid #e9ecef;"><?php echo $row['ip_address'] ?></td>
                          <td style="border-bottom: 1px solid #e9ecef;"><?php echo $row['country'] ?></td>
                          <td style="border-bottom: 1px solid #e9ecef;"><?php echo $row['visiting_date_time'] ?></td>
                          </tr>
                      <?php } } else{
                      ?>
                      <tr style="border: none;">
                      <td colspan="4" style="border-bottom: 1px solid #e9ecef;">No website visitors found.</td>
                      </tr>
                      <?php
                      }?>
                      </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>


<?php require('footer.inc.php'); ?>