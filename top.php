<?php

require('connection_inc.php');
require('functions_inc.php');
require('add_to_cart_inc.php');


$cat_res=mysqli_query($con,"select * from categories where status=1 order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
    $cat_arr[]=$row;
}

$obj =new add_to_cart();
$totalProduct = $obj->totalProduct();
if(isset($_SESSION['firstname'])){
    $uid=$_SESSION['user_id'];

    if(isset($_GET['wishlist_id'])){
        $wid=$_GET['wishlist_id'];
        mysqli_query($con,"delete from wishlist where id='$wid' and user_id='$uid'");
    }

    $wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}

$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/',$script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];

$meta_title="Book Dealers - Home Page";
$meta_desc="Book Dealers";
$meta_keyword="Book Dealers";

if($mypage=='product.php'){
    $product_id=get_safe_value($con,$_GET['id']);
    $product_meta=mysqli_fetch_assoc(mysqli_query($con,"select * from product where id='$product_id' "));
    $meta_title=$product_meta['meta_title'];
    $meta_desc=$product_meta['meta_desc'];
    $meta_keyword=$product_meta['meta_keyword'];
}
if($mypage=='contact.php'){
    $meta_title='Book Dealers - Contact Us Page';
}
if($mypage=='categories.php'){
    $meta_title='Book Dealers - Categories Page';
}
if($mypage=='login.php'){
    $meta_title='Book Dealers - Login Page';
}
if($mypage=='register.php'){
    $meta_title='Book Dealers - Register Page';
}
if($mypage=='cart.php'){
    $meta_title='Book Dealers - Cart Page';
}
if($mypage=='wishlist.php'){
    $meta_title='Book Dealers - Wishlist Page';
}
if($mypage=='thankyou.php'){
    $meta_title='Book Dealers - Thank You Page';
}
if($mypage=='search.php'){
    $meta_title='Book Dealers - Search Page';
}
if($mypage=='reset_pass.php'){
    $meta_title='Book Dealers - Reset Password Page';
}
if($mypage=='recover_email.php'){
    $meta_title='Book Dealers - Email Recover Page';
}
if($mypage=='my_order.php'){
    $meta_title='Book Dealers - My Order Page';
}
if($mypage=='my_order_details.php'){
    $meta_title='Book Dealers - My Order Details Page';
}
if($mypage=='checkout.php'){
    $meta_title='Book Dealers - Check Out Page';
}




?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title; ?></title>
    <meta name="description" content="<?php echo $meta_desc; ?>">
    <meta name="keyword" content="<?php echo $meta_keyword; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    
    <!-- Google fonts links -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Mulish&family=Ubuntu&display=swap" rel="stylesheet">

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl Carousel min css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    
    <!-- developer css -->
    <link rel="stylesheet" href="css/user_style.css">
    

    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">

    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <style>
        .htc__shopping__cart a span.htc__wishlist {
            background: #c43b68;
            border-radius: 100%;
            color: #fff;
            font-size: 9px;
            height: 17px;
            line-height: 19px;
            position: absolute;
            right: 40px;
            text-align: center;
            top: -4px;
            width: 17px;
        }
        .header__account a::before {
            top: 7px;
        }




        
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
    </style>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <!-- Start Header Style -->
        <header id="htc__header" class="htc__header__area header--one font_style">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.php"><img src="https://img.icons8.com/ios-filled/30/000000/school.png" alt="logo images"> <h3>Book Dealers</h3></a>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-6 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <li><a href="index.php">Home</a></li>
                                        <li class="drop"><a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Categories</a>
                                            <ul class="dropdown  multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                <?php 
                                                foreach($cat_arr as $list){
                                                ?>
                                                    <li class="dropdown-submenu">
                                                    <a href="categories.php?id=<?php echo $list['id']; ?>"><?php echo $list['categories'] ?></a>
                                                    <?php
                                                    $cat_id=$list['id'];
                                                    $sub_cat_res=mysqli_query($con,"select * from sub_categories where status='1' and categories_id='$cat_id'");
                                                    if(mysqli_num_rows($sub_cat_res)>0){
                                                    ?>
                                                        <ul class="dropdown-menu">
                                                        <?php
                                                        while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
                                                        ?>
                                                            <li><a href="categories.php?id=<?php echo $list['id']; ?>&sub_categories=<?php echo $sub_cat_rows['id']; ?>"><?php echo $sub_cat_rows['sub_categories']; ?></a></li>
                                                        <?php
                                                        }
                                                        ?>
                                                        </ul>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    </li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="contact.php">contact</a></li>
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <li class="drop"><a href="#">Categories</a>
                                                <ul class="dropdown">
                                                <?php 
                                                    foreach($cat_arr as $list){
                                                        ?>
                                                        <li><a href="categories.php?id=<?php echo $list['id'] ?>"><?php echo $list['categories'] ?></a></li>
                                                        <?php
                                                    }
                                                ?>
                                                </ul>
                                            </li>
                                            <li><a href="contact.php">contact</a></li>
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-3 col-lg-4 col-sm-4 col-xs-4">
                                <div class="header__right">
                                    <div class="header__search search search__open">
                                        <a href="#"><i class="icon-magnifier icons"></i></a>
                                    </div>
                                    <div class="header__account">
                                        <?php 
                                            if(isset($_SESSION['firstname']) && $_SESSION['firstname']!=''){
                                                ?>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span><?php echo $_SESSION['firstname']; ?>&nbsp;<?php echo $_SESSION['lastname']; ?></span>
                                                    </a>

                                                    <ul aria-labelledby="dropdownMenuLink" class="dropdown-menu" role="menu">
                                                        <li>
                                                        <a href="my_order.php">My Orders</a>
                                                        </li>
                                                        <li>
                                                        <a href="profile.php">My Profile</a>
                                                        </li>
                                                        <li>
                                                        <a href="logout.php">Logout</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <?php
                                                      
                                            }else{
                                                ?>
                                                <a href="login.php">Login/Register</a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="htc__shopping__cart">
                                        
                                        <?php 
                                        if(isset($_SESSION['firstname'])){
                                            ?>
                                            <a href="wishlist.php"><i class="icon-heart icons"></i></a>
                                            <a  style="margin-right:25px;" href="wishlist.php"><span class="htc__wishlist"><?php echo $wishlist_count; ?></span></a>
                                            <?php
                                        }
                                        ?>

                                        <a href="cart.php"><i class="icon-handbag icons"></i></a>
                                        <a href="cart.php"><span class="htc__qua"><?php echo $totalProduct; ?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Area -->
        
<div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="search.php" method="get">
                                    <input placeholder="Search here... " name="str" type="text">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search Popap -->

