<?php
require('connection_inc.php');
require('functions_inc.php');

$coupon_code = get_safe_value($con,$_POST['coupon_code']);

if(isset($_SESSION['COUPON_ID'])){
    unset($_SESSION['COUPON_CODE']);
    unset($_SESSION['COUPON_ID']);
    unset($_SESSION['COUPON_VALUE']);
    unset($_SESSION['FINAL_PRICE']);
}

$res=mysqli_query($con,"select * from coupon_master where coupon_code='$coupon_code' and status='1'");
$count=mysqli_num_rows($res);

$jsonArr=array();

$cart_total=0;
foreach($_SESSION['cart'] as $key=>$val){
    $productArr = get_product($con,'','',$key);
    $price = $productArr['0']['price'];
    $qty=$val['qty'];
    $cart_total=$cart_total+($price*$qty);
}

if($count>0){
    $row=mysqli_fetch_assoc($res);

    $coupon_value=$row['coupon_value'];
    $coupon_id=$row['id'];
    $coupon_type=$row['coupon_type'];
    $cart_min_value=$row['cart_min_value'];

    
    if($cart_min_value>$cart_total){
        $jsonArr=array('is_error'=>'yes','result'=>'₹'.$cart_total,'dd'=>'Cart total value must be ₹'.$cart_min_value);
    }else{
        if($coupon_type=='Rupee'){
            $final_price=$cart_total-$coupon_value;
        }else{
            $final_price=$cart_total-(($cart_total*$coupon_value)/100);
        }
        $dd=$cart_total-$final_price;
        $_SESSION['COUPON_ID']=$coupon_id;
        $_SESSION['FINAL_PRICE']=$final_price;
        $_SESSION['COUPON_VALUE']=$dd;
        $_SESSION['COUPON_CODE']=$coupon_code;
        $jsonArr=array('is_error'=>'no','result'=>'₹'.$final_price,'dd'=>'₹'.$dd);
    }
}else{
    $jsonArr=array('is_error'=>'yes','result'=>'₹'.$cart_total,'dd'=>'Coupon code not found');
}
echo json_encode($jsonArr); 
?>