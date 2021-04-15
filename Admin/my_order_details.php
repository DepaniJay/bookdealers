<?php

include('includes/header.php');
include('includes/navbar.php');
isAdmin();
$order_id=get_safe_value($con,$_GET['id']);

$coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value,coupon_code from `orders` where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
$coupon_code=$coupon_details['coupon_code'];

if($coupon_value=''){
    $coupon_value=0;
}

if(isset($_POST['submit'])){
    $update_order_status=$_POST['update_order_status'];
    $update_sql='';
    if($update_order_status==3){
        $length=$_POST['length'];
        $breadth=$_POST['breadth'];
        $height=$_POST['height'];
        $weight=$_POST['weight'];

        $update_sql=",length='$length',breadth='$breadth',height='$height',weight='$weight'";
    }

    if($update_order_status==5){
        mysqli_query($con,"update `orders` set order_status='$update_order_status',payment_status='success' where id='$order_id' ");
    }else{
        mysqli_query($con,"update `orders` set order_status='$update_order_status' $update_sql where id='$order_id' ");
    }


    if($update_order_status==3){
        $token=validShipRocketToken($con);
        placeShipRocketOrder($con,$token,$order_id);
    }

    if($update_order_status==4){
        $ship_order=mysqli_fetch_assoc(mysqli_query($con,"select ship_order_id from `orders` where id='$order_id'"));
        if($ship_order['ship_order_id']>0){
            $token=validShipRocketToken($con);
            cancelShipRocketOrder($token,$ship_order['ship_order_id']);
        }
    }
    moveCurrentPageToOtherPage('order.php');
}
?> 
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
                    </div>


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
                                    $res = mysqli_query($con,"select distinct(order_details.id),order_details.*,product.name,product.image,`orders`.address,`orders`.city,`orders`.pincode from order_details,product,`orders` where order_details.order_id='$order_id' and order_details.product_id=product.id");
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
                                <div>
                                    <form action="" method="POST">
                                    <div class="form-group">
                                    <br>
                                        <label for="update_order_status">Select Status</label>
                                        <select class="form-control" name="update_order_status" id="update_order_status" onchange="select_status()">
                                            <option class="bg-secondary text-white">Select Status</option>
                                            <?php
                                            $res = mysqli_query($con,"select * from order_status");
                                            while($row=mysqli_fetch_assoc($res)){
                                                if($row['id']==$order_status){
                                                    echo "<option selected value=".$row['id'].">".$row['name']."</option>";
                                                }else{
                                                    echo "<option  value=".$row['id'].">".$row['name']."</option>";
                                                }
                                            } 
                                            ?>
                                        </select>
                                        <br>
                                        <div id="shipped_box" style="display:none;" class="table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td><input type="text" class="form-control" name="length" placeholder="Length"/></td>
                                                        <td><input type="text" class="form-control" name="breadth" placeholder="Breadth"/></td>
                                                        <td><input type="text" class="form-control" name="height" placeholder="Height"/></td>
                                                        <td><input type="text" class="form-control" name="weight" placeholder="Weight"/></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <input type="submit" name="submit" value="Change Status" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    </div>
                                    </form>
                                </div>
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