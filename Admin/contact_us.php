<?php

include('includes/header.php');
include('includes/navbar.php');
isAdmin();
if(isset($_GET['type']) && $_GET['type']!=''){

    $type = get_safe_value($con,$_GET['type']);

    if($type=='delete'){
        $id = get_safe_value($con,$_GET['id']);
        $delete_sql = "delete from contact_us where id='$id' ";
        mysqli_query($con, $delete_sql);
    }
}

if(isset($_GET['id']) && $_GET['id']!=''){
    $contact_us_id=get_safe_value($con,$_GET['id']);
    $sql="select * from contact_us where id='$contact_us_id'";
}else{
    $sql = "select * from contact_us order by id desc";
}

$res = mysqli_query($con, $sql);

?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Contact Us</h1>
                    </div>


                    <!-- page content  -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Contact Us Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover " id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Query</th>
                                            <th>Date & Time</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Query</th>
                                            <th>Date & Time</th>
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
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['mobile']; ?></td>
                                        <td><?php echo $row['comment']; ?></td>
                                        <td><?php echo $row['added_on']; ?></td>
                                        <td>
                                        <?php
                                            echo "<span style='width:100px;height:30px; padding-top:8px;' class='badge badge-danger text-center '><a class='text-white' href='?type=delete&id=".$row['id']."'><i class='mr-1 las la-trash-alt'></i>Delete</a></span>";
                                        ?>
                                        </td>
                                    </tr>
                                <?php } ?>
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