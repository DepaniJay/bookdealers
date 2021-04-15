<?php
require('includes/connection_inc.php');
include('includes/functions_inc.php');

$_SESSION['error'] = '';

if(isset($_POST['submit'])){
    $email = get_safe_value($con,$_POST['email']);
    $password = get_safe_value($con,$_POST['password']);

    $selectquery = "select * from admin_users where email='$email'";
    $query = mysqli_query($con,$selectquery);
    $count = mysqli_num_rows($query);

    if($count){
        // fetch password from database 
        $email_pass = mysqli_fetch_assoc($query);
        $db_pass = $email_pass['password'];

        // user enter password and database password is same or not verify by password_verify function
        $pass_decode = password_verify($password, $db_pass);
        
        if($pass_decode){

            if($email_pass['status']==1){
                $_SESSION['ADMIN_LOGIN'] = "yes";
                $_SESSION['name'] = $email_pass['name'];
                $_SESSION['user_id']=$email_pass['id'];
                $_SESSION['admin_level']=$email_pass['adminlevel'];
                $_SESSION['ADMIN_USERNAME'] = $email;
                $timestamp = get_current_time();

                
                mysqli_query($con,"insert into activity_admin_users(user_id,login_time) values('".$email_pass['id']."','$timestamp')");
                
                $res=mysqli_fetch_assoc(mysqli_query($con,"select id from activity_admin_users"));
                $_SESSION['ACTIVITY_ID']=$res['id'];

                if(isset($_POST['rememberme'])){
                    setcookie('emailcookie',$email,time()+86400);
                    setcookie('passwordcookie',$password,time()+86400);
                    moveCurrentPageToOtherPage('admin_index.php');
                    die();
                }else{
                    moveCurrentPageToOtherPage('admin_index.php');
                    die();
                }
            }else{
                $_SESSION['error'] = "Account Deactivated";
            }
        }else{
            $_SESSION['error'] = "Password is not matching";
        }
    }else{
        $_SESSION['error'] = "Email does not exist";
    }
}
      
?>





<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Book Dealers - Login Page</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" value="
                                                <?php 
                                                if(isset($_COOKIE['emailcookie'])){
                                                    echo $_COOKIE['emailcookie'];
                                                } 
                                                ?>
                                                " id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" value="<?php if(isset($_COOKIE['passwordcookie'])){echo $_COOKIE['passwordcookie'];}  ?>"
                                                id="exampleInputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="rememberme" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button  name="submit" class="btn btn-primary btn-user btn-block">
                                            Login Now
                                        </button>
                                        <hr>
                                        
                                        <!-- login with google button exicute code to show button to user -->
                                        <a href="#" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="#" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <!-- this code for print error  -->
                                    <div class="text-center text-danger small"><?php echo $_SESSION['error'];
                                    $_SESSION['error']='';  ?></div>
                                    <!-- print error message about your account is activate or not -->
                                    <div class="text-center small text-success">
                                    <?php 
                                        if(isset($_SESSION['activate_msg'])){
                                            echo $_SESSION['activate_msg'];  
                                        }else{
                                            echo $_SESSION['activate_msg'] = "You are logged out. Please login again.";
                                        }
                                    ?>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="recover_email.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>