<?php
require('top.php');
$notification_id = get_safe_value($con, $_GET['id']);
$notification_id = decrypt_id($notification_id);
$user_id = $_SESSION['USER_ID'];

if(strpos($notification_id,".") !== false || is_numeric($notification_id) === false){
?>
<script>
window.location.href="notifications.php";
</script>
<?php
die();
}
?>

<head>
<style>
    .price-check{
    display: flex;
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
  padding: .625em;
  text-align: center;
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
  
  .price-check{
    display: unset;
}
}

@media screen and (max-width: 1280px){
  .message_heading_div{
    padding-top: 12px;
  }
}

@media screen and (width: 1280px){
  .message_heading_div{
    padding-top: 0;
  }
}

    </style>
</head>

          <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Notification Details</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="notifications_view_details.php?id=<?php echo encrypt_id($notification_id) ?>">Notification Details</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <?php
            $res = mysqli_query($con, "select * from notifications where user_id = '$user_id' and id='$notification_id' ");
            $row = mysqli_fetch_assoc($res);
            ?>

    <div style="margin: 4% 10%; border: 1px solid #ddd; border-radius: 6px; margin-top: 0; background-color:  white;">

    
          <div style="border-top-right-radius: 6px; border-top-left-radius: 6px; border-bottom: 1px solid #ddd; padding: 10px 0; padding-left: 20px; font-size: 17px; background-color: #85004b; color: white; font-weight: 400;">
          <?php if(mysqli_num_rows($res)>0){ ?>
          Subject: <?php echo ucfirst($row['subject']) ?>
          <?php } else{
          echo "Subject: No subject found";
          }
          ?>
        </div>

          <div class="container" style="width: 100%;">
              <div class="row">
                <div class="col-12" style="padding: 2% 0;">
                    <div style="margin: 0 5%; margin-right: 3%;">
                        <div class="message_heading_div" style="border-bottom: 1px solid #ced4da; padding-bottom: 8px;">
                        <h5 style="font-size: 25px; color: #a2a2a2;">Message</h5>
                        </div>
                        <h5 style="color: #515151; font-size: 17px;"> <br>
                        <?php if(mysqli_num_rows($res)>0){ ?>
                        <?php echo ucfirst($row['message']) ?>
                        <?php } else{
                        echo "No message found.";
                        }
                        ?>
                      </h5>
                    </div>
                </div>
              </div>
          </div>

    </div>

<?php
require('footer.php');
?>