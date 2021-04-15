<?php 
require('top.php');

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
                                  <span class="breadcrumb-item active">Forgot Password</span>
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
									<h2 class="title__line--6">Update Password</h2>
                                    <p>Enter password properly!</p><br>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="contact-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="password" placeholder="Enter Your Password*" style="width:100%" required>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="cpassword" placeholder="Confirm Password*" style="width:100%" required>
										</div>
									</div>
									<div class="contact-btn">
										<button type="submit" name="submit" class="fv-btn">Reset Password</button>
									</div>
								</form>
                                    <hr>
                                    <!-- this code for print error  -->
                                    <div class="text-center text-danger small"><?php echo $_SESSION['error'];  ?></div>
                                    <br>
                                    <h5>
                                        <div class="text-center">
                                            <a class="small" href="register.php">Create an Account!</a>
                                        </div>
                                        <br>
                                        <div class="text-center">
                                            <a class="small" href="login.php">Already have an account? Login!</a>
                                        </div>
                                    </h5>
							</div>
                        </div>
				</div>	
            </div>
        </section>
        <!-- End Contact Area -->
        <!-- End Banner Area -->
         <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
<?php
require('footer.php');
?>