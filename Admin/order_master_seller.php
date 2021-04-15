<?php

include('includes/header.php');
include('includes/navbar.php');


?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Orders Master</h1>
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
                                            <th>Order ID</th>
                                            <th>Order Date</th>
                                            <th>Address</th>
                                            <th>Payment Type</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Show Order Details</th>
                                            <th>Download Invoice</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Order Date</th>
                                            <th>Address</th>
                                            <th>Payment Type</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Show Order Details</th>
                                            <th>Download Invoice</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php  
                                    $i=1;
                                    $res = mysqli_query($con,"select DISTINCT(`orders`.id),`orders`.*,order_status.name as order_status_str from order_details,product,`orders`,order_status where order_status.id=`orders`.order_status and product.id=order_details.product_id and `orders`.id=order_details.order_id and product.added_by='".$_SESSION['user_id']."' order by `orders`.id desc");

                                    while($row=mysqli_fetch_assoc($res)){ ?>

                                    <tr class="text-center">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['id']; ?></td>
                                        <td> <?php echo $row['added_on']; ?></td>
                                        <td> <?php echo $row['address']; ?><br><?php echo $row['city']; ?>,&nbsp;&nbsp;<?php echo $row['pincode']; ?></td>
                                        <td> <?php echo $row['payment_type']; ?></td>
                                        <td> <?php echo $row['payment_status']; ?></td>
                                        <td> <?php echo $row['order_status_str']; ?></td>
                                        <td><span style="width:100px;height:30px; padding-top: 8px;" class="badge badge-primary text-center"><a href="seller_order_details.php?id=<?php echo $row['id']; ?>" class="text-white">Show Order</a></span></td>
                                        <td><span style="width:100px;height:30px; padding-top: 8px;" class="badge badge-danger text-center"><a href="#" class="text-white"><i class="mr-1 fa fa-download"></i>Download</a></span></td>
                                    </tr>

                                <?php $i++;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php


include('includes/footer.php');
include('includes/scripts.php');

?>