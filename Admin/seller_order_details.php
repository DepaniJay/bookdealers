<?php

include('includes/header.php');
include('includes/navbar.php');

$order_id=get_safe_value($con,$_GET['id']);

$coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value,coupon_code from `orders` where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
$coupon_code=$coupon_details['coupon_code'];

if($coupon_value=''){
    $coupon_value=0;
}

?> 
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
                    </div>


                    <!-- page content  -->
                     <!-- page content  -->
                     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Orders Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover " id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php
                                    $i=1;
                                    $res = mysqli_query($con,"select distinct(order_details.id),order_details.*,product.name,product.image,`orders`.address,`orders`.city,`orders`.pincode from order_details,product,`orders` where order_details.order_id='$order_id' and order_details.product_id=product.id and product.added_by='".$_SESSION['user_id']."'");
                                    $total_price=0;
                                    while($row=mysqli_fetch_assoc($res)){
                                    $address = $row['address'];
                                    $city = $row['city'];
                                    $pincode = $row['pincode'];
                                    $total_price=$total_price + ($row['qty']*$row['price']);
                                    ?>
                                    <tr class="text-center">
                                        <td><?php echo $i; ?></td>
                                        <td> <?php echo $row['name']; ?></td>
                                        <td><a href="#"><img src="../media/product/<?php echo $row['image']; ?>" width="50px" height="50px" alt="product img" /></a></td>
                                        <td> <?php echo $row['qty']; ?></td>
                                        <td>₹<?php echo $row['price']; ?></td>
                                        <td>₹<?php echo $row['qty']*$row['price']; ?></td>
                                    </tr>
                                    <?php $i++;} ?>
                                    <tfoot class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </tfoot>
                                    <tr class="text-center">
                                        <td colspan="5">Total Price</td>
                                        <td>₹<?php echo $total_price; ?></td>
                                    </tr>
                                    <?php
                                    if($coupon_value>0){
                                        ?>
                                        <tr class="text-center">
                                            <td colspan="5">Discount Price<br/>Coupon Code</td>
                                            <td>₹<?php 
                                            echo $coupon_value;
                                            echo "<br>($coupon_code)"; 
                                            ?></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td colspan="5">New Total Price</td>
                                            <td>₹<?php echo $total_price-$coupon_value; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                            <div id="address_details" class="m-4">
                                <strong>Address:</strong>
                                <?php echo $address; ?>, 
                                <?php echo $city; ?>, 
                                <?php echo $pincode; ?><br><br>
                                <strong>Order Status:</strong>
                                <?php $order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"select order_status.name,order_status.id from order_status,`orders` where `orders`.id='$order_id' and `orders`.order_status=order_status.id ")); 
                                $order_status=$order_status_arr['id'];
                                echo $order_status_arr['name'];
                                ?>
                            </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <script>
            function select_status(){
                var update_order_status=jQuery('#update_order_status').val();
                if(update_order_status==3){
                    jQuery('#shipped_box').show();
                }
            }
            </script>

<?php


include('includes/footer.php');
include('includes/scripts.php');

?>