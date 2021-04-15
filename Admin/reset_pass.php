<?php 
require('includes/connection_inc.php');
include('includes/functions_inc.php');

if(isset($_POST['submit'])){

    // get token from the url
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        
        $password = get_safe_value($con,$_POST['password']);
        $cpassword = get_safe_value($con,$_POST['cpassword']);
        
        // encrypt password
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
        
        
        if($password === $cpassword){
            
            $updatequery = "update authentication set password='$pass' where token='$token' ";
            $iquery = mysqli_query($con,$updatequery);
            
            if($iquery){
                $_SESSION['activate_msg'] = "Your password has been updated";
                moveCurrentPageToOtherPage('login.php');
            }else{
                $_SESSION['error'] = "Some error is coming, please update password after some time";
            }
            
        }else{
            $_SESSION['error'] = "Password are not matching";
        }
    }else{
        $_SESSION['error'] = "No token found";
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

    <title>Book Dealers - Forgot Password Page</title>

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
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Update Password</h1>
                                        <p class="mb-4">Enter password properly!</p>
                                    </div>
                                    <form action="" method="POST" class="user">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" aria-describedby="emailHelp"
                                                placeholder="New password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="cpassword" class="form-control form-control-user"
                                                id="exampleInputcPassword" aria-describedby="emailHelp"
                                                placeholder="Confirm password" required>
                                        </div>
                                        <button name="submit" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center text-danger small"><?php echo $_SESSION['error'];  ?></div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Already have an account? Login!</a>
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