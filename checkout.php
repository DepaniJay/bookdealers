<?php
require('top.php');
$error_msg='';
// prx($_SESSION['cart']);
if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
    moveCurrentPageToOtherPage('index.php');
}

if(isset($_POST['submit'])){
    $email = get_safe_value($con,$_POST['email']);
    $password = get_safe_value($con,$_POST['password']);

    $selectquery = "select * from authentication where email='$email' and status='1' ";
    $query = mysqli_query($con,$selectquery);
    $count = mysqli_num_rows($query);

    if($count){
        // fetch password from database 
        $email_pass = mysqli_fetch_assoc($query);
        $db_pass = $email_pass['password'];

        // user enter password and database password is same or not verify by password_verify function
        $pass_decode = password_verify($password, $db_pass);
        
        if($pass_decode){
            $_SESSION['firstname'] = $email_pass['firstname'];
            $_SESSION['user_id']=$email_pass['id'];
            $_SESSION['lastname'] = $email_pass['lastname'];
            $_SESSION['email'] = $email_pass['email'];
            $_SESSION['mobile'] = $email_pass['mobile'];
        
                if(isset($_POST['rememberme'])){
                    setcookie('emailcookie',$email,time()+86400);
                    setcookie('passwordcookie',$password,time()+86400);
                    ?>
                        <script>
                            window.location.href=window.location.href;
                        </script>
                    <?php
                }else{
                    ?>
                        <script>
                            window.location.href=window.location.href;
                        </script>
                    <?php
                }
        }else{
            $_SESSION['error'] = "Password is not matching";
        }
    }else{
        $_SESSION['error'] = "Email does not exist";
    }
}
$cart_total=0;
foreach($_SESSION['cart'] as $key=>$val){
    $productArr = get_product($con,'','',$key);
    $price = $productArr['0']['price'];
    $qty=$val['qty'];
    $cart_total=$cart_total+($price*$qty);
}
$timestamp = get_current_time();

if(isset($_POST['submit_payment'])){
    $address = get_safe_value($con,$_POST['address']);
    $pincode = get_safe_value($con,$_POST['pincode']);
    $city = get_safe_value($con,$_POST['city']);
    $state = get_safe_value($con,$_POST['state']);
    $country = get_safe_value($con,$_POST['country']);
    $payment_type = get_safe_value($con,$_POST['payment_type']);
    $user_id = $_SESSION['user_id'];
    $total_price = $cart_total;
    $payment_status = 'pending';
    if($payment_type=='COD'){
        $payment_status = 'success';
    }
    $order_status = '1';
    
    if(isset($_SESSION['COUPON_ID'])){
        $coupon_code=$_SESSION['COUPON_CODE'];
        $coupon_id=$_SESSION['COUPON_ID'];
        $coupon_value=$_SESSION['COUPON_VALUE'];
        $final_price=$_SESSION['FINAL_PRICE'];
        $total_price=$total_price-$coupon_value;
        unset($_SESSION['COUPON_CODE']);
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_VALUE']);
        unset($_SESSION['FINAL_PRICE']);
    }else{
        $coupon_code='';
        $coupon_id='';
        $coupon_value='';
        $final_price='';
    }
    
    mysqli_query($con,"insert into `orders`(`user_id`, `address`, `city`, `state`, `country`, `pincode`, `payment_type`, `total_price`,`old_total_price`, `payment_status`, `order_status`,`length`,`breadth`,`height`,`weight`,`ship_order_id`,`ship_shipment_id`,`coupon_id`,`coupon_value`,`coupon_code`,'added_on') values('$user_id','$address','$city','$state','$country','$pincode','$payment_type','$total_price','$cart_total','$payment_status','$order_status','0','0','0','0','0','0','$coupon_id','$coupon_value','$coupon_code','$timestamp')");

    $order_id = mysqli_insert_id($con);

    foreach($_SESSION['cart'] as $key=>$val){
        $productArr = get_product($con,'','',$key);
        $price = $productArr['0']['price'];
        $qty=$val['qty'];

        mysqli_query($con,"insert into `order_details`(`order_id`, `product_id`, `qty`, `price`,`added_on`) values('$order_id','$key','$qty','$price','$timestamp')");
    }
    unset($_SESSION['cart']);
    moveCurrentPageToOtherPage('thankyou.php');
}

?>

        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/bg.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    
                                    <?php
                                    $accordion_class="accordion__title";
                                    if(!isset($_SESSION['firstname'])){
                                        $accordion_class="accordion__hide";
                                    ?>
                                    <div class="accordion__title">
                                        Checkout Method
                                    </div>
                                    <div class="accordion__body">
                                        <div class="accordion__body__form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="checkout-method__login">
								                        <form id="contact-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

                                                            <h5 class="checkout-method__title">Login</h5>
                                                            <div class="single-input">
                                                            <input type="email" name="email" value="
                                                                <?php 
                                                                if(isset($_COOKIE['emailcookie'])){
                                                                    echo $_COOKIE['emailcookie'];
                                                                } 
                                                                ?>
                                                                " placeholder="Enter your email*" style="width:100%">
                                                            </div>
                                                            <div class="single-input">
                                                                <input type="password" name="password" value="<?php if(isset($_COOKIE['passwordcookie'])){echo $_COOKIE['passwordcookie'];}  ?>" placeholder="Your password*" style="width:100%">
                                                            </div>
                                                            <div class="custom-control custom-checkbox small">
                                                                <input type="checkbox" name="rememberme" class="custom-control-input" id="customCheck">
                                                                <label class="custom-control-label " for="customCheck">&nbsp;Remember Me</label>
                                                            </div>
                                                            <p class="require">* Required fields</p>
                                                            <div class="dark-btn">
                                                                <button type="submit" name="submit" class="fv-btn">Login Now</button>
                                                            </div>
                                                        </form>
                                                        <hr>
                                                        <!-- this code for print error  -->
                                                        <div class="text-center text-danger small"><?php echo $error_msg; $error_msg='';  ?></div>
                                                        <div class="text-center">
                                                            <a class="small" href="recover_email.php">Forgot Password?</a>
                                                        </div>
                                                        <div class="text-center">
                                                            <a class="medium" href="register.php">Create an Account!</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="<?php echo $accordion_class; ?>">
                                        Address Information
                                    </div>
                                    <form action="" method="post">
                                        <div class="accordion__body">
                                            <div class="bilinfo">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="single-input">
                                                            <input type="text" name="address" placeholder="Street Address" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name="pincode" placeholder="Post code/ zip" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name="city" placeholder="City" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name="state" placeholder="State" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name="country" placeholder="Country" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo $accordion_class; ?>">
                                            payment information
                                        </div>
                                        <div class="accordion__body">
                                            <div class="paymentinfo">
                                                <div class="single-method">
                                                    <input type="radio" name="payment_type" value="COD" required/> COD
                                                </div>
                                                <div class="single-method">
                                                    <input type="radio" name="payment_type" value="payu" required/> PayU
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div>
                                            <input class="fv-btn" type="submit" name="submit_payment" >
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php
                                    $cart_total=0;
                                    if(isset($_SESSION['cart']) && $_SESSION['cart']!=''){

                                    foreach($_SESSION['cart'] as $key=>$val){
                                        $productArr = get_product($con,'','',$key);
                                        $pname = $productArr['0']['name'];
                                        $mrp = $productArr['0']['mrp'];
                                        $price = $productArr['0']['price'];
                                        $image = $productArr['0']['image'];
                                        $pname = $productArr['0']['name'];
                                        $qty=$val['qty'];
                                        $cart_total=$cart_total+($price*$qty);
                                ?>
                                <div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="media/product/<?php echo $image; ?>" width="58" height="70" alt="ordered item">
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $pname; ?></a>
                                        <span class="price">₹<?php echo $qty*$price; ?></span>
                                    </div>
                                    <div class="single-item__remove">
                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="zmdi zmdi-delete"></i></a>
                                    </div>
                                </div>

                                <?php
                                    } 
                                }
                                ?>
                               
                            </div>
                            <div class="ordre-details__total">
                                <h5>Order total</h5>
                                <span class="price">₹<?php echo $cart_total;  ?></span>
                            </div>
                            <div class="ordre-details__total">
                                <input type="text" style="height:30px;" name="coupon_code" id="coupon_code" placeholder="Coupon Code" required>&nbsp;&nbsp;&nbsp;
                                <input class="fv-btn" style="height:30px;" type="submit" name="apply" value="Apply Coupon" onclick="set_coupon()">
                            </div>
                            <span class="text-danger" style="margin-left:30px;" id="coupon_result"></span>
                            <div class="order-details__count">
                                <div class="order-details__count__single" id="coupon_box" style="display:none;">
                                    <h5>Discount</h5>
                                    <span class="price" id="coupon_price"></span>
                                </div>
                                <div class="order-details__count__single">
                                    <h5>Order total</h5>
                                    <span class="price" id="order_total_price">₹<?php echo $cart_total;  ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
<script>
    function set_coupon(){
        var coupon_code=jQuery('#coupon_code').val();
        if(coupon_code!=''){
            jQuery.ajax({
                url:'set_coupon.php',
                type:'post',
                data:'coupon_code='+coupon_code,
                success:function(result){
                    var data=jQuery.parseJSON(result);
                    if(data.is_error=='yes'){
                        jQuery('#coupon_box').hide();
                        jQuery('#coupon_result').html(data.dd);
                        jQuery('#order_total_price').html(data.result);
                    }
                    if(data.is_error=='no'){
                        jQuery('#coupon_box').show();
                        jQuery('#coupon_price').html(data.dd);
                        jQuery('#order_total_price').html(data.result);
                    }   
                }
            });
        }
    }
</script>
<?php
if(isset($_SESSION['COUPON_ID'])){
    unset($_SESSION['COUPON_CODE']);
    unset($_SESSION['COUPON_ID']);
    unset($_SESSION['COUPON_VALUE']);
    unset($_SESSION['FINAL_PRICE']);
}
require('footer.php');
?>