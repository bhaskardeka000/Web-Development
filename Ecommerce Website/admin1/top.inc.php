<?php
require('connection.inc.php');
require('function.inc.php');
require('paths.inc.php');

if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){
  // Do nothing
}
else{
    header('location:login.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <link rel="stylesheet" href="assets/nice-select-custom/css/nice-select.css">
  </head>
  <body>
    <div class="main-wrapper">
      <div class="header">
        <div class="header-left active">
          <a href="index.php" class="logo">
            <img src="assets/img/logo.png" alt="">
          </a>
          <a href="index.php" class="logo-small">
          <i class="fa-solid fa-circle-dot" style="color: white;"></i>
          </a>
          <a id="toggle_btn" href="javascript:void(0);"></a>
        </div>
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
          <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </a>
        <ul class="nav user-menu">
          <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
              <span class="user-img">
              <i class="fa-solid fa-circle-user user_admin_outside_icon"></i>
                <span class="status online"></span>
              </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
              <div class="profilename">
                <div class="profileset">
                  <span class="user-img">
                  <i class="fa-solid fa-circle-user user_admin_inside_icon"></i>
                    <span class="status online status_online_inside"></span>
                  </span>
                  <div class="profilesets">
                    <h5>Admin</h5>
                  </div>
                </div>
                <hr class="m-0">
                <form id="logout_form" action="logout.php" method="post">

                  <?php
                  if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['logout_form'])){
                    $logout_form_generated_token = bin2hex(random_bytes(16));
                    $_SESSION['csrf_token']['logout_form'] = $logout_form_generated_token;
                    $_SESSION['last_generated_token_time']['logout_form'] = time();
                  }
                  else{
                    $interval = 60 * 25;
                    if(time() -  $_SESSION['last_generated_token_time']['logout_form']>= $interval){
                        $logout_form_generated_token = bin2hex(random_bytes(16));
                        $_SESSION['csrf_token']['logout_form'] = $logout_form_generated_token;
                        $_SESSION['last_generated_token_time']['logout_form'] = time();
                    }
                    else{
                        $logout_form_generated_token = $_SESSION['csrf_token']['logout_form'];
                    }
                  }
                  ?>

                  <input type="hidden" name="logout_form_token" value="<?php echo $logout_form_generated_token ?>">
                </form>
                <a class="dropdown-item logout pb-0" onclick="document.forms['logout_form'].submit()">
                  <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
              </div>
            </div>
          </li>
        </ul>
        <div class="dropdown mobile-user-menu">
          <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item logout pb-0 logout_mobile" href="logout.php">
                  <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout </a>
          </div>
        </div>
      </div>
      <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
          <div class="sidebar-menu">
            <ul>
            <li>
                <a href="index.php">
                <span class="menu_master_icons"><i class="fas fa-tachometer-alt"></i></span>
                  <span>&nbsp;Dashboard</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="categories.php">
                <span class="menu_master_icons"><i class="fa fa-th-large" aria-hidden="true"></i></span>
                  <span>&nbsp;Categories Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="products.php">
                <span class="menu_master_icons"><i class="fa fa-box" aria-hidden="true"></i></span>
                  <span>&nbsp;&nbsp;Products Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="order_master.php">
                <span class="menu_master_icons"><i class="fa fa-truck"></i></span>
                  <span>&nbsp;Orders Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="users.php">
                <span class="menu_master_icons"><i class="fa-solid fa-user-plus"></i></span>
                  <span>&nbsp;Users Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="careers.php">
                <span class="menu_master_icons"><i class="fa fa-file" aria-hidden="true"></i></span>
                  <span>&nbsp;&nbsp;&nbsp;Careers Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="contact_us.php">
                <span class="menu_master_icons"><i class="fa-solid fa-envelope"></i></span>
                  <span>&nbsp;&nbsp;Contact Us Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="partners.php">
                <span class="menu_master_icons"><i class="fa fa-briefcase"></i></span>
                  <span>&nbsp;&nbsp;Partners Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="notifications.php">
                <span class="menu_master_icons"><i class="fa-solid fa-bell"></i></span>
                  <span>&nbsp;&nbsp;Notifications Master</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>
              <li>
                <a href="backup.php">
                <span class="menu_master_icons"><i class="fa fa-upload"></i></span>
                  <span>&nbsp;&nbsp;Backup Data</span>
                  <span class="menu-arrow"></span>
                </a>
              </li>

            </ul>
          </div>
        </div>
      </div>
      <div class="page-wrapper">