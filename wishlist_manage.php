<?php
require('connection_inc.php');
require('functions_inc.php');
require('add_to_cart_inc.php');

$pid = get_safe_value($con,$_POST['pid']);
$type = get_safe_value($con,$_POST['type']);

if(isset($_SESSION['firstname'])){
    $uid=$_SESSION['user_id'];
    if(mysqli_num_rows(mysqli_query($con,"select * from `wishlist` where user_id='$uid' and product_id='$pid'"))>0){
        // echo "Already added";
    }else{
        // mysqli_query($con,"INSERT INTO `wishlist`(`user_id`, `product_id`) VALUES ('$uid','$pid')");
        wishlist_add($con,$uid,$pid);
        unset($_SESSION['WISHLIST_ID']);
    }
    echo $total_record=mysqli_num_rows(mysqli_query($con,"select * from `wishlist` where user_id='$uid'"));
}else{
    $_SESSION['WISHLIST_ID']=$pid;
    echo "not_login";
}
?>