<?php
include('includes/header.php');
include('includes/navbar.php');
isAdmin();
$_SESSION['error'] = '';
$name='';
$email='';
$mobile='';
$image='';
$gender='';

$image_required='required';

if(isset($_GET['id']) && $_GET['id']!=''){
    $image_required='';
    $id = get_safe_value($con,$_GET['id']);
    $admin_select_sql = "select * from admin_users where id='$id' ";
    $res = mysqli_query($con,$admin_select_sql);
    $check=mysqli_num_rows($res);
    if($check>0){
        $admin_row = mysqli_fetch_assoc($res);
        $name = $admin_row['name'];
        $email = $admin_row['email'];
        $mobile = $admin_row['mobile'];
        $image = $admin_row['image'];
        $gender = $admin_row['gender'];
    }else{
        moveCurrentPageToOtherPage('admin.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $name = get_safe_value($con,$_POST['name']);
    $email = get_safe_value($con,$_POST['email']);
    $mobile = get_safe_value($con,$_POST['mobile']);
    $gender = get_safe_value($con,$_POST['gender']);
    $password = get_safe_value($con,$_POST['password']);
    $cpassword = get_safe_value($con,$_POST['cpassword']);

    // Encrypt password using bluefish algorithms
    $pass = password_hash($password, PASSWORD_BCRYPT);
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

    $token = bin2hex(random_bytes(15));

    $admin_sql = "select * from admin_users where email='$email' ";
    $result = mysqli_query($con,$admin_sql);
    $admin_count=mysqli_num_rows($result);

    if($admin_count>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData = mysqli_fetch_assoc($result);
            if($id==$getData['id']){

            } else{
                $_SESSION['error'] = "email already exist";
            }
        }else{
            $_SESSION['error'] = "email already exist";
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
                if(isset($password) && isset($cpassword)){
                    if($password === $cpassword){
                        $updatequery = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`gender`='$gender',`password`='$pass',`cpassword`='$cpass',`image`='$image' WHERE id='$id' ";
                        mysqli_query($con,$updatequery);
                        moveCurrentPageToOtherPage('admin.php');
                        die();
            
                    }else{
                        $_SESSION['error'] = "Password are not matching";
                    }
                }else if(isset($password)){
                    $_SESSION['error'] = "Please enter Confirm password";
                }else if(isset($cpassword)){
                    $_SESSION['error'] = "Please enter password";
                }else{
                    $updatequery = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`gender`='$gender',`image`='$image' WHERE id='$id' ";
                    mysqli_query($con,$updatequery);
                    moveCurrentPageToOtherPage('admin.php');
                    die();
                }

            }else{
                if(isset($password) && isset($cpassword)){
                    if($password === $cpassword){
                        $updatequery = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`gender`='$gender',`password`='$pass',`cpassword`='$cpass' WHERE id='$id' ";
                        mysqli_query($con,$updatequery);
                        moveCurrentPageToOtherPage('admin.php');
                        die();
            
                    }else{
                        $_SESSION['error'] = "Password are not matching";
                    }
                }else if(isset($password)){
                    $_SESSION['error'] = "Please enter Confirm password";
                }else if(isset($cpassword)){
                    $_SESSION['error'] = "Please enter password";
                }else{
                    $updatequery = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`gender`='$gender' WHERE id='$id' ";
                    mysqli_query($con,$updatequery);
                    moveCurrentPageToOtherPage('admin.php');
                    die();
                }
            }
            
        }else{
            $image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],'../media/product/'.$image);

            if($password === $cpassword){
                $timestamp = get_current_time();
                $insertquery = "INSERT INTO `admin_users`(`name`,`email`,`mobile`,`password`,`cpassword`,`token`,`adminlevel`,`status`,`image`,`gender`,`added_on`) VALUES('$name','$email','$mobile','$pass','$cpass','$token','Admin','1','$image','$gender','$timestamp')";
                mysqli_query($con,$insertquery);
                moveCurrentPageToOtherPage('admin.php');
                die();
    
            }else{
                $_SESSION['error'] = "Password are not matching";
            }
        }
    }
}



?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Admin</h1>
                    </div>


                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile No</label>
                            <input type="number" name="mobile" class="form-control" id="mobile" placeholder="Enter your mobile no" value="<?php echo $mobile; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" <?php echo $image_required; ?>/>
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

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Enter confirm password">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <div class="text-danger mt-3">
                        <?php 
                        if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        }
                        ?>
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