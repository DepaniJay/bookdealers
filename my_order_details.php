<?php
require('top.php');

if(!isset($_SESSION['user_id'])){
    moveCurrentPageToOtherPage('login.php');
}

$order_id=get_safe_value($con,$_GET['id']);

$coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value from `orders` where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];

if($coupon_value==''){
    $coupon_value=0;
}

?>
     
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
                            <span class="breadcrumb-item active">Order Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->

<!-- wishlist-area start -->
<div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Product Name</th>
                                                <th class="product-thumbnail">Product Image</th>
                                                <th class="product-quantity">Qty</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-subtotal">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $uid = $_SESSION['user_id'];
                                            $res = mysqli_query($con,"select distinct(order_details.id),order_details.*,product.name,product.image from order_details,product,`orders` where order_details.order_id='$order_id' and `orders`.user_id='$uid' and order_details.product_id=product.id");
                                            $total_price=0;
                                            while($row=mysqli_fetch_assoc($res)){
                                            $total_price=$total_price + ($row['qty']*$row['price']);
                                            ?>
                                            <tr>
                                                <td class="product-name"> <?php echo $row['name']; ?></td>
                                                <td class="product-thumbnail"><a href="#"><img src="media/product/<?php echo $row['image']; ?>" alt="product img" /></a></td>
                                                <td class="product-name"> <?php echo $row['qty']; ?></td>
                                                <td class="product-name">₹<?php echo $row['price']; ?></td>
                                                <td class="product-name">₹<?php echo $row['qty']*$row['price']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="product-name" colspan="4">Total Price</td>
                                                <td class="product-name">₹<?php echo $total_price; ?></td>
                                            </tr>
                                            <?php 
                                            if($coupon_value>0){
                                            ?>
                                            <tr>
                                                <td class="product-name" colspan="4">Discount Price</td>
                                                <td class="product-name">₹<?php echo $coupon_value; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="product-name" colspan="4">New Total Price</td>
                                                <td class="product-name">₹<?php echo $total_price-$coupon_value; ?></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->


<?php
require('footer.php');
?>