<?php require('top.inc.php'); ?>

<div class="content">
          <div class="row">
            <!-- <div class="col-lg-3 col-sm-6 col-12">
              <div class="dash-widget">
                <div class="dash-widgetimg">
                  <span>
                    <img src="assets/img/icons/dash1.svg" alt="img">
                  </span>
                </div>
                <div class="dash-widgetcontent">
                  <h5>$ <span class="counters" data-count="307144.00">$307,144.00</span>
                  </h5>
                  <h6>Total Purchase Due</h6>
                </div>
              </div>
            </div> -->
            <div>
              <h2 class="main_page_heading">Dashboard</h2>
            </div>


            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count">
                <div class="dash-counts">
                  <h4>100</h4>
                  <h5>Pending Orders</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="shopping-bag"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count das1">
                <div class="dash-counts">
                  <h4>100</h4>
                  <h5>User Registrations</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="user"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count das2">
                <div class="dash-counts">
                  <h4>100</h4>
                  <h5>Total Visitors</h5>
                </div>
                <div class="dash-imgs">
                  <i data-feather="pie-chart"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
              <div class="dash-count das3">
                <div class="dash-counts">
                  <h4>105</h4>
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
                  <h3>₹<span class="counters" data-count="4385.00">$4,385.00</span>
                  </h3>
                  <h5>Total Sales Amount</h5>
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-0">
            <div class="card-body">
              <h4 class="card-title">Website Visitors</h4>
              <div class="table-responsive">
                <table class="table datatable website_visitor_table">
                  <thead>
                    <tr>
                      <th>Visitors ID</th>
                      <th>IP Address</th>
                      <th>Country</th>
                      <th>Visiting Data and Time</th>
                    </tr>
                  </thead>
                    <tbody>
                    <?php
                    $res = mysqli_query($con, "select * from website_visitors");
                    while($row = mysqli_fetch_assoc($res)){
                    ?>
                        <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['ip_address'] ?></td>
                        <td><?php echo $row['country'] ?></td>
                        <td><?php echo $row['visiting_date_time'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

<?php require('footer.inc.php'); ?>
<script>
    if ($('.website_visitor_table').length > 0) {
        $.fn.DataTable.ext.pager.numbers_length = 3;
        $('.website_visitor_table').DataTable({
            "bLengthChange": false,
            "info": false,
            'pagingType': 'simple_numbers',
            "pageLength": 5,
            "bFilter": true,
            "sDom": 'fBtlpi',
            // "bScrollInfinite": true,
        // "bScrollCollapse": true,
        // "sScrollY": "100px",
            "ordering": false,
            "language": {
                search: ' ',
                sLengthMenu: '_MENU_',
                searchPlaceholder: "Search...",
                info: "_START_ - _END_ of _TOTAL_ items",
            },
            initComplete: (settings, json) => {
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.dataTables_filter').appendTo('.search-input');
            },
        });
    }
</script>
