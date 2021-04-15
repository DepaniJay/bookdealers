<?php
require('top.php');

$_SESSION['error'] = '';

// check user click on submit button or not
if(isset($_POST['submit'])){
    $firstname = get_safe_value($con,$_POST['firstname']);
    $lastname = get_safe_value($con,$_POST['lastname']);
    $email = get_safe_value($con,$_POST['email']);
    $mobile = get_safe_value($con,$_POST['mobile']);
    $password = get_safe_value($con,$_POST['password']);
    $cpassword = get_safe_value($con,$_POST['cpassword']);


    // Encrypt password using bluefish algorithms
    $pass = password_hash($password, PASSWORD_BCRYPT);
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

    // genrete uniqe token 
    $token = bin2hex(random_bytes(15));

    $selectquery = "select * from authentication where email='$email' ";
    $query = mysqli_query($con,$selectquery);

    // mysqli_num_rows check how many row is available in table
    $count = mysqli_num_rows($query);

    if($count>0){
        $_SESSION['error'] = "Email already exists";
    }else{
        if($password === $cpassword){
            $timestamp = get_current_time();
            $insertquery = "insert into authentication(firstname,lastname,email,mobile,password,cpassword,token,status,added_on) values('$firstname','$lastname','$email','$mobile','$pass','$cpass','$token','0','$timestamp')";
            $iquery = mysqli_query($con,$insertquery);

            if($iquery){
                $subject = "Email Activation";
                $body = "Hi, $firstname"." $lastname. Click here too activate your account http://localhost/Book%20Dealers/activate.php?token=$token";
                $sender_email = "From: jdcoder007@gmail.com";

                if(mail($email, $subject, $body, $sender_email)){
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

        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/bg.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Register</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
            <div class="container">
                <div class="row">

					<div class="col-md-12">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Create an Account!</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="contact-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
									<div class="single-contact-form">
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="text" name="firstname" placeholder="Your first name*" style="width:100%" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="text" name="lastname" placeholder="Your last name*" style="width:100%" required>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" placeholder="Enter your email*" style="width:100%" required>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="number" name="mobile" placeholder="Your Mobile*" style="width:100%" required>
										</div>
									</div>
									<div class="single-contact-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="password" name="password" placeholder="Your password*" style="width:100%" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="password" name="cpassword" placeholder="Repeat password" style="width:100%" required>
                                                </div>
                                            </div>
                                        </div>
									</div>
									
									<div class="contact-btn">
										<button type="submit" name="submit" class="fv-btn">Register Account</button>
									</div>
								</form>
                                <hr>
                                <h5 class="text-center text-danger ">
                                    <?php echo $_SESSION['error'];  ?>
                                </h5>
                                <br>
                                <div class="text-center">
                                        <a class="medium" href="login.php">Already have an account? Login!</a>
                                </div>
							</div>
                        </div>
				</div>	
            </div>
        </section>
        <!-- End Contact Area -->
        <!-- End Banner Area -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
<?php
require('footer.php');
?>