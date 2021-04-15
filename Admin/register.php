<?php 

// include connection and function files
require('includes/connection_inc.php');
include('includes/functions_inc.php');
include('smtp/PHPMailerAutoload.php');
$_SESSION['error'] = '';

// check user click on submit button or not
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

    // genrete uniqe token 
    $token = bin2hex(random_bytes(15));

    $selectquery = "select * from `admin_users` where email='$email' ";
    $query = mysqli_query($con,$selectquery);

    // mysqli_num_rows check how many row is available in table
    $count = mysqli_num_rows($query);

    if($_FILES['image']['type']!='' && ($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')){
        $_SESSION['error'] = "Please selcet only png,jpg and jpeg image formate ";
    }

    if($count>0){
        $_SESSION['error'] = "Email already exists";
    }else{
        if($password === $cpassword){
            $timestamp = get_current_time();

            $image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],'../media/product/'.$image);

            $insertquery = "INSERT INTO `admin_users`(`name`,`email`,`mobile`,`password`,`cpassword`,`token`,`adminlevel`,`status`,`image`,`gender`,`added_on`) VALUES('$name','$email','$mobile','$pass','$cpass','$token','Admin','1','jay.jpg','$gender','$timestamp')";
            $iquery = mysqli_query($con,$insertquery);

            if($iquery){
                $subject = "Email Activation";
                // $body = "Hi, $name Click here too activate your account http://localhost/Book%20Dealers/Admin/activate.php?token=$token";
                $body = "Hi, $name Click here too activate your account https://bookdealers.herokuapp.com/Admin/activate.php?token=$token";
                $smtp_mailer=smtp_mailer($email,$subject,$body);
                if($smtp_mailer=='Sent'){
                    $_SESSION['activate_msg'] = "Check your mail to activate your account $email";
                    moveCurrentPageToOtherPage('login.php');
                }else{
                    $_SESSION['error'] = "Some error is coming to send activation email.";
                }
            }else{
                $_SESSION['error'] = "Some error is coming, please register after some time";
            }

        }else{
            $_SESSION['error'] = "Password are not matching";
        }
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

    <title>Book Dealers - Register Page</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/custom.css">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="" method="POST" class="user">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-user" id="exampleName" placeholder="Enter Your Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email"  name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" required>
                                </div>

                                <div class="form-group">
                                    <input type="number" name="mobile" class="form-control form-control-user" id="exampleInputMobile" placeholder="Mobile No" required>
                                </div>

                                <div class="form-group">
                                    <label for="image">Profile Image</label>
                                    <input type="file" name="image" class="form-control" id="image" required/>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option class="bg-secondary text-white" value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option> 
                                    </select>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="cpassword" class="form-control form-control-user"
                                            id="exampleRepeatcPassword" placeholder="Repeat Password" required>
                                    </div>
                                </div>
                                <button name="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                                <a href="#" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="#" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <!-- print error message  -->
                            <div class="text-center text-danger small"><?php echo $_SESSION['error'];  ?></div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
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