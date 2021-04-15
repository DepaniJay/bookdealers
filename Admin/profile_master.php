<?php

include('includes/header.php');
include('includes/navbar.php');


?>
 
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    <a href="edit_profile_master.php?id=<?php echo $_SESSION['user_id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i>&nbsp;Edit Profile</a>
</div>


<!-- page content  -->
<div class="container-fluid">
    <div class="shadow rounded">
        <div class="row">
            <div class="col-xl-4 col-md-4 col-12">
                <div class="text-center">
                <?php $dashboard_user_profile=dashboard_user_profile($con,$_SESSION['user_id']); 
                foreach($dashboard_user_profile as $list){
                ?>
                    <img class="mt-4 img-profile rounded-circle" width="300" height="300" src="../media/profile/<?php echo $list['image']; ?>" alt="Profile Photo">
                </div>
                <br>
                <div class="text-center">
                    <h2><?php echo $list['name']; ?></h2>
                </div>
            </div>
            <div class="col-xl-8 col-md-8 col-12">
                    <div class="my-3 text-capitalize" style="font-size:25px;">
                        <strong>Name:</strong>
                        <?php echo $list['name'];?>
                    </div>
                    <div class="my-3" style="font-size:25px;">
                        <strong>Email:</strong>
                        <?php echo $list['email'];?>
                    </div>
                    <div class="my-3" style="font-size:25px;">
                        <strong>Mobile:</strong>
                        <?php echo $list['mobile'];?>
                    </div>
                    <div class="my-3 text-capitalize" style="font-size:25px;">
                        <strong>Gender:</strong>
                        <?php echo $list['gender'];?>
                    </div>
                    <div class="my-3 text-capitalize" style="font-size:25px;">
                        <strong>Account Status:</strong>
                        <?php 
                        if($list['status']==1){
                            echo "Activated";
                        }else{
                            echo "Deactivated";
                        }
                        ?>
                    </div>
            </div>
            <?php } ?>

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