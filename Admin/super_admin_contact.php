<?php
include('includes/header.php');
include('includes/navbar.php');

if(isset($_POST['submit'])){
    $comment=get_safe_value($con,$_POST['comment']);
    $res=mysqli_fetch_assoc(mysqli_query($con,"select name,email,mobile from admin_users where id='".$_SESSION['user_id']."'"));
    $name=$res['name'];
    $email=$res['email'];
    $mobile=$res['mobile'];
    $timestamp=get_current_time();

    mysqli_query($con,"insert into contact_us(name,email,mobile,comment,added_on) values('$name','$email','$mobile','$comment','$timestamp')");

    $msg="Thank You for contact us, Our team contact you with 48 hours";
}
?>

 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Contact Super Admin</h1>
                    </div>
                    <div class="mb-5 mt-3">
                        <p class="mb-0 text-gray-800">This form fillup when you whant to add New Categories/Sub Categories for you Product and anything reagarding website or something else just write your query and send message to me, i will contact you with in some days.</p>
                        <p class="text-center text-success"><?php 
                        if(isset($msg) && $msg!=''){
                            echo $msg;
                            $msg='';
                        }
                        ?></p>
                    </div>


                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="comment">Describe Your Proposal</label>
                            <textarea name="comment" class="form-control" id="comment" placeholder="Enter your praposal" required></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <div class="text-danger mt-3">
                        <?php echo $_SESSION['error']; 
                        $_SESSION['error']='';?>
                        </div>
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
<?php

include('includes/footer.php');
include('includes/scripts.php');

?>
