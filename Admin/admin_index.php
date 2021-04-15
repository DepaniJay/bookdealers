 <?php

include('includes/header.php');
include('includes/navbar.php');


?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

<!-- ********************************** Page Heading **************************************** -->

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

<!-- ***************************** Earnings (Monthly) Card Example ******************************** -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            <?php
                                            if($_SESSION['admin_level']=='Admin'){
                                                echo "Books";
                                            }else{
                                                echo "Users";
                                            }
                                            ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            if($_SESSION['admin_level']=='Admin'){
                                                $dashboard_books=dashboard_books($con,$_SESSION['user_id']);
                                                echo $dashboard_books;
                                            }else{
                                                $dashboard_users=dashboard_users($con,'');
                                                echo $dashboard_users;
                                            }   
                                            ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="las la-users la-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Pending Requests Card Example -->
                         <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                New Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            if($_SESSION['admin_level']=='Admin'){
                                                $dashboard_new_orders=dashboard_new_orders($con,$_SESSION['user_id']);
                                                echo $dashboard_new_orders;
                                            }else{
                                                $dashboard_new_orders=dashboard_new_orders($con,'');
                                                echo $dashboard_new_orders;
                                            }
                                            ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="las la-shopping-bag la-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Pending Requests Card Example -->
                         <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Completed Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                            if($_SESSION['admin_level']=='Admin'){
                                                $dashboard_completed_orders=dashboard_completed_orders($con,$_SESSION['user_id']);
                                                echo $dashboard_completed_orders;
                                            }else{
                                                $dashboard_completed_orders=dashboard_completed_orders($con,'');
                                                echo $dashboard_completed_orders;
                                            }
                                            ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="las la-shopping-bag la-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Earnings (Annual)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?php
                                            if($_SESSION['admin_level']=='Admin'){
                                                $dashboard_earnings=dashboard_earnings($con,$_SESSION['user_id']);
                                                echo $dashboard_earnings;
                                            }else{
                                                $dashboard_earnings=dashboard_earnings($con,'');
                                                echo $dashboard_earnings;
                                            }
                                            ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="las la-rupee-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
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