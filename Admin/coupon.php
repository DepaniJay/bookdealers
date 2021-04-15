<?php

include('includes/header.php');
include('includes/navbar.php');
isAdmin();
if(isset($_GET['type']) && $_GET['type']!=''){

    $type = get_safe_value($con,$_GET['type']);

    if($type=='status'){
        $operation = get_safe_value($con,$_GET['operation']);
        $id = get_safe_value($con,$_GET['id']);

        if($operation=='active'){
            $status='1';
        }else{
            $status='0';
        }

        $update_status_sql = "update `coupon_master` set status='$status' where id='$id' ";
        mysqli_query($con, $update_status_sql);
    }

    if($type=='delete'){
        $id = get_safe_value($con,$_GET['id']);
        $delete_sql = "delete from `coupon_master` where id='$id' ";
        mysqli_query($con, $delete_sql);
    }
}


$sql = "select * from coupon_master order by id desc";
$res = mysqli_query($con, $sql);

?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Coupon Master</h1>
                        <a href="add_coupon.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i>&nbsp;Add Coupon</a>
                    </div>


                    <!-- page content  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Coupon Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover " id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Coupon Code</th>
                                            <th>Coupon Value</th>
                                            <th>Coupon Type</th>
                                            <th>Min Value</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Coupon Code</th>
                                            <th>Coupon Value</th>
                                            <th>Coupon Type</th>
                                            <th>Min Value</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php  
                                    $i=1;
                                    while($row=mysqli_fetch_assoc($res)){ ?>
                                    <tr class="text-center">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['coupon_code']; ?></td>
                                        <td><?php echo $row['coupon_value']; ?></td>
                                        <td><?php echo $row['coupon_type']; ?></td>
                                        <td><?php echo $row['cart_min_value']; ?></td>
                                        <td>
                                        <?php
                                            if($row['status']==1){ 
                                                echo "<span style='width:100px;height:30px; padding-top: 8px;' class='badge badge-success text-center'><a class='text-white' href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></span>&nbsp;";
                                            } else{
                                                echo "<span style='width:100px;height:30px; padding-top: 8px;' class='badge badge-warning text-center'><a class='text-white' href='?type=status&operation=active&id=".$row['id']."' >Deactive</a></span>&nbsp;";
                                            }  
                                        ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo "<span style='width:100px;height:30px; padding-top: 8px;' class='badge badge-primary text-center'><a href='add_coupon.php?id=".$row['id']."' class='text-white'><i class='mr-1 las la-edit'></i>Edit</a></span>&nbsp;";
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo "<span style='width:100px;height:30px; padding-top: 8px;' class='badge badge-danger text-center'><a class='text-white' href='?type=delete&id=".$row['id']."'><i class='mr-1 las la-trash-alt'></i>Delete</a></span>";
                                            ?>
                                        </td>
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