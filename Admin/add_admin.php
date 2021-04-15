<?php
include('includes/header.php');
include('includes/navbar.php');
isAdmin();
$_SESSION['error'] = '';
$name='';
$email='';
$mobile='';

if(isset($_GET['id']) && $_GET['id']!=''){
    $id = get_safe_value($con,$_GET['id']);
    $admin_select_sql = "select * from admin_users where id='$id' ";
    $res = mysqli_query($con,$admin_select_sql);
    $check=mysqli_num_rows($res);
    if($check>0){
        $admin_row = mysqli_fetch_assoc($res);
        $name = $admin_row['name'];
        $email = $admin_row['email'];
        $mobile = $admin_row['mobile'];
    }else{
        moveCurrentPageToOtherPage('admin.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $name = get_safe_value($con,$_POST['name']);
    $email = get_safe_value($con,$_POST['email']);
    $mobile = get_safe_value($con,$_POST['mobile']);
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
    
    if($_SESSION['error']==''){
        if(isset($_GET['id']) && $_GET['id']!=''){

            if(isset($password) && isset($cpassword)){
                if($password === $cpassword){
                    $updatequery = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile',`password`='$pass',`cpassword`='$cpass' WHERE id='$id' ";
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
                $updatequery = "UPDATE `admin_users` SET `name`='$name',`email`='$email',`mobile`='$mobile' WHERE id='$id' ";
                mysqli_query($con,$updatequery);
                moveCurrentPageToOtherPage('admin.php');
                die();
            }
        }else{
            if($password === $cpassword){
                $timestamp = get_current_time();
                $insertquery = "insert into admin_users(name,email,mobile,password,cpassword,token,adminlevel,status,added_on) values('$name','$email','$mobile','$pass','$cpass','$token','Admin','1','$timestamp')";
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