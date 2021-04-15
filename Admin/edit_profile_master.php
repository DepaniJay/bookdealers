<?php

include('includes/header.php');
include('includes/navbar.php');

$name='';
$email='';
$mobile='';
$image='';
$password='';
$gender='';
$status='';

$image_required='required';

if(isset($_GET['id']) && $_GET['id']!=''){
    $image_required='';
    $id = get_safe_value($con,$_GET['id']);
    $sql = "select * from admin_users where id='$id'";
    $res = mysqli_query($con,$sql);
    $check=mysqli_num_rows($res);
    if($check>0){
        $row = mysqli_fetch_assoc($res);
        $name=$row['name'];
        $email=$row['email'];
        $mobile=$row['mobile'];
        $password=$row['password'];
        $gender=$row['gender'];
        $status=$row['status'];

    }else{
        moveCurrentPageToOtherPage('profile_master.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $name = get_safe_value($con,$_POST['name']);
    $email = get_safe_value($con,$_POST['email']);
    $mobile = get_safe_value($con,$_POST['mobile']);
    $gender = get_safe_value($con,$_POST['gender']);
    $status = get_safe_value($con,$_POST['account_status']);

    $select_sql = "select * from admin_users where email='$email' and mobile='$mobile'";
    $res = mysqli_query($con,$select_sql);
    $check=mysqli_num_rows($res);

    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData = mysqli_fetch_assoc($res);
            if($id==$getData['id']){
                
            } else{
                $_SESSION['error'] = "Email/Mobile number already exist";
            }
        }else{
            $_SESSION['error'] = "Eamil/Mobile number already exist";
        }
    }
    
    if($_FILES['image']['type']!='' && ($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')){
        $_SESSION['error'] = "Please selcet only png,jpg and jpeg image formate ";
    }

    if($_SESSION['error']==''){
        if(isset($_GET['id']) && $_GET['id']!=''){

            if($_FILES['image']['name']!=''){
                $image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],'../media/profile/'.$image);

                $update_sql = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`gender`='$gender',`status`='$status',`image`='$image' WHERE id='$id'";

            }else{

                $update_sql = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`gender`='$gender',`status`='$status' WHERE id='$id'";
                
            }
            mysqli_query($con,$update_sql);
        }
        moveCurrentPageToOtherPage('profile_master.php');
        die();
    }
}

if(isset($_POST['submit_password'])){
    $current_password=get_safe_value($con,$_POST['current_password']);
    $new_password=get_safe_value($con,$_POST['new_password']);
    $confirm_password=get_safe_value($con,$_POST['confirm_password']);

    $pass_decode = password_verify($current_password, $password);

    if($pass_decode){
        $pass = password_hash($new_password, PASSWORD_BCRYPT);
        $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

        if($new_password === $confirm_password){
            mysqli_query($con,"update `admin_users` set password='$pass',cpassword='$cpass' where id='$id'");
        }else{
            $_SESSION['error'] = "New password and confirm password are not matching";
        }
    }else{
        $_SESSION['error'] = "Your Current Password is not matching";
    }
}

?>

 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
                    </div>


                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name*" value="<?php echo $name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your Email*" value="<?php echo $email; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="number" name="mobile" class="form-control" id="mobile" placeholder="Enter your Mobile number*" value="<?php echo $mobile; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control" id="image" <?php echo $image_required; ?>/>
                        </div>
                        
                        <div class="form-group">
                            <label for="account_status">Account Status</label>
                            <select class="form-control" name="account_status" id="account_status" required>
                                <option class="bg-secondary text-white" value="">Select</option>
                                <?php
                                if($status==1){
                                    ?>
                                        <option value="1" selected>Activated</option>
                                        <option value="0">Deactivated</option> 
                                    <?php
                                }elseif($status==0){
                                    ?>
                                        <option value="1">Activated</option>
                                        <option value="0" selected>Deactivated</option> 
                                    <?php
                                }else{
                                    ?>
                                        <option value="1">Activate</option>
                                        <option value="0">Deactivate</option> 
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option class="bg-secondary text-white" value="">Select</option>
                                <?php
                                if($gender=='male'){
                                    ?>
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option> 
                                    <?php
                                }elseif($gender=='female'){
                                    ?>
                                        <option value="male">Male</option>
                                        <option value="female" selected>Female</option> 
                                    <?php
                                }else{
                                    ?>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option> 
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <div class="text-danger mt-3">
                        <?php echo $_SESSION['error']; 
                        $_SESSION['error']='';?>
                        </div>
                    </form>


                </div>
                <!-- /.container-fluid -->
                    <br>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Password</h1>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Enter current password*"  required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Enter new password*"  required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Enter confirm password*"  required>
                        </div>



                        <button type="submit" name="submit_password" class="btn btn-primary">Submit</button>
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
