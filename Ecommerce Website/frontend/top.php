<?php 
require('connection.inc.php');
// if(!isset($_SESSION['IP_ADDRESS_EXISTS'])){
//     $_SESSION['IP_ADDRESS_EXISTS'] = "true";
//     include('track_ip_address.php');
// }
require('function.inc.php');
require('paths.inc.php');
require('add_to_cart.inc.php');
$cat_res = mysqli_query($con, "select * from categories where status=1 order by categories desc");
$cat_arr = array();
while($row = mysqli_fetch_assoc($cat_res)){
$cat_arr[] = $row;
}

$obj = new add_to_cart();
$totalProduct = $obj -> totalProduct();
?>

<!DOCTYPE html>
<html lang="en">
<!-- molla/index-1.html  22 Nov 2019 09:55:06 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Molla - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skins/skin-demo-2.css">
    <link rel="stylesheet" href="assets/css/demos/demo-2.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="age_verification_assets/css/age-verification.css" rel="stylesheet">

    <style>
/* clears the ‘X’ from Chrome */
input[type="search"]::-webkit-search-cancel-button{ display: none; }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <header class="header header-2 header-intro-clearance">
            <div class="header-top head-top-message" style="background-color: #85004b;">
                    <p id="header-left-p-tag" >Get wine, liquor, beer, energy drink delivered at your doorstep.</p>
            </div><!-- End .header-top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        
                        <a href="index.php" class="logo" title="Scotch Club International">
                            <img src="assets/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="search.php" method="get">
                                <div class="header-search-wrapper search-wrapper-wide">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="str" id="q" placeholder="Search for products ..." required autocomplete="off" onclick="showdiv()">
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                </div><!-- End .header-search-wrapper -->
                                <div class="list-group" id="show-list">
                                <!-- Display suggestion/autocomplete box(For large screen) here -->
                                </div>
                            </form>
                        </div><!-- End .header-search -->
                    </div>

                    <div class="header-right">
                        <div class="account">
                            <?php 
                            if(isset($_SESSION['USER_LOGIN'])){
                            ?>
                           <!-- echo "<a href='logout.php' title='Login'> <div class='icon'> <i class='icon-user'></i> </div> <p>Logout</p> </a>"; -->
                           
                            <div class="dropdown cart-dropdown">
                                <a href="#" class="dropdown-toggle account_icon" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <div class="icon">
                                        <i class='icon-user'></i>
                                    </div>
                                    <p>Account</p>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" style="right: -72px; top: 70px; padding: 15px 0px 14px 20px; border-top: 1px solid #85004b; width: 0px; min-width: 12rem;">
                            
                                            <div class="product-cart-details" style="max-width: none;  margin-bottom: 10px;">
                                                <h4 class="product-title">
                                                    <a href="my_orders.php" style="font-size: 14px;">My Orders</a>
                                                </h4>
                                            </div><!-- End .product-cart-details -->
                                            
                                            <div class="product-cart-details" style="max-width: none;  margin-bottom: 10px;">
                                                <h4 class="product-title">
                                                    <a href="profile.php" style="font-size: 14px;">Profile</a>
                                                </h4>
                                            </div><!-- End .product-cart-details -->
                        
                                            <div class="product-cart-details" style="max-width: none;">
                                                <h4 class="product-title">

                                                    <?php
                                                    if(!isset($_SESSION['last_generated_token_time']) || !isset($_SESSION['last_generated_token_time']['logout_form'])){
                                                        $logout_form_generated_token = uniqid();
                                                        $_SESSION['csrf_token']['logout_form'] = $logout_form_generated_token;
                                                        $_SESSION['last_generated_token_time']['logout_form'] = time();
                                                    }
                                                    else{
                                                        $interval = 60 * 1;
                                                        if(time() -  $_SESSION['last_generated_token_time']['logout_form']>= $interval){
                                                            $logout_form_generated_token = uniqid();
                                                            $_SESSION['csrf_token']['logout_form'] = $logout_form_generated_token;
                                                            $_SESSION['last_generated_token_time']['logout_form'] = time();
                                                        }
                                                        else{
                                                            $logout_form_generated_token = $_SESSION['csrf_token']['logout_form'];
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <input type="hidden" id="logout_form_token" value="<?php echo $logout_form_generated_token ?>">
                                                    <a onclick="user_logout()" style="font-size: 14px; cursor: pointer;">Logout</a>
                                                </h4>
                                            </div><!-- End .product-cart-details -->

                                </div><!-- End .dropdown-menu -->
                            </div><!-- End .cart-dropdown -->
                            <?php
                            }
                            else{
                                echo "<a class='account_icon' href='login.php' title='Login'> <div class='icon'> <i class='icon-user'></i> </div> <p>Login</p> </a>";
                            }
                            ?>
                        </div><!-- End .account -->

                         <!-- <div class="wishlist">
                            <a href="my_orders.php" title="Wishlist">
                                <div class="icon">
                                      <i class="fa-solid fa-receipt" style="font-size: 22px;"></i>
                                </div>
                                <p>My Orders</p>
                            </a>
                         </div> --><!-- End .compare-dropdown -->
                         <?php
                            if(isset($_SESSION['USER_LOGIN'])){
                                $user_id = $_SESSION['USER_ID'];
                                $res = mysqli_query($con, "select * from notifications where user_id = '$user_id' and status = 0");
                                $notification_count = mysqli_num_rows($res);
                         ?>
                         <div class="dropdown cart-dropdown wishlist">
                            <a href="notifications.php" class="dropdown-toggle notification_icon" id="notification_click" title="Notifications">
                                <div class="icon">
                                <i class="fa-solid fa-bell" style="font-size: 24px; color: #85004b;"></i>
                                    <span class="wishlist-count" style="background-color: #ababab;"> <?php echo $notification_count?> </span>
                                </div>
                                <p>Notifications</p>
                            </a>
                        </div><!-- End .cart-dropdown -->

                         <?php
                         }
                         ?>
                        
                         <div class="dropdown cart-dropdown">
                            <a href="cart.php" class="dropdown-toggle cart_icon" title="Cart">
                                <div class="icon">
                                    <i class="icon-shopping-cart" style="color: #85004b;"></i>
                                    <span class="cart-count" style="background-color: #ababab;"> <?php echo $totalProduct?> </span>
                                </div>
                                <p>Cart</p>
                            </a>
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

            <div class="header-bottom sticky-header">
                <div class="container">
                    <div class="header-left">
                        <div class="dropdown category-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                                ALL CATEGORIES
                            </a>

                            <div class="dropdown-menu">
                                <nav class="side-nav">
                                    <ul class="menu-vertical sf-arrows">
                                    <?php
                                    foreach($cat_arr as $list){
                                    ?>
                                        <li><a href="categories.php?id=<?php echo encrypt_id($list['id']) ?>" style="text-transform: uppercase;"> <?php echo $list['categories']?> </a></li>
                                    <?php
                                    }
                                    ?>
                                    </ul><!-- End .menu-vertical -->
                                </nav><!-- End .side-nav -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .category-dropdown -->
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container">
                                    <a href="index.php" class="sf-with-ul">Home</a>
                                </li>
                                <li>
                                    <a href="all_products.php" class="sf-with-ul">All Products</a>

                                </li>
                                <li>
                                    <a href="career.php" class="sf-with-ul">Career</a>
                                </li>
                                <li>
                                    <a href="contact_us.php" class="sf-with-ul">Contact Us</a>
                                </li>
                                <li>
                                    <a href="partner_with_us.php" class="sf-with-ul">Partner With Us</a>
                                </li>

                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-center -->


                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->