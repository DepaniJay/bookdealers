<?php 
require('top.php');
include('smtp/PHPMailerAutoload.php');
if(isset($_POST['submit'])){
    $email = get_safe_value($con,$_POST['email']);

    // verify email enter by user and database is same or not
    $selectquery = "select * from authentication where email='$email' ";
    $query = mysqli_query($con,$selectquery);
    $count = mysqli_num_rows($query);

    if($count){

        // fetch data from database for perticuler email user 
        $userdata = mysqli_fetch_assoc($query);
        $firstname = $userdata['firstname'];
        $lastname = $userdata['lastname'];
        $token = $userdata['token'];


        // dend email using mail function
        $subject = "Password Reset";
        // $body = "Hi, $firstname"." $lastname. Click here too reset your password http://localhost/Book%20Dealers/reset_pass.php?token=$token ";
        $body = "Hi, $firstname"." $lastname. Click here too reset your password https://bookdealers.herokuapp.com/reset_pass.php?token=$token ";
        $smtp_mailer=smtp_mailer($email,$subject,$body); 
        if($smtp_mailer=='Sent'){
            $_SESSION['activate_msg'] = "Check your mail to reset your password $email";
            moveCurrentPageToOtherPage('login.php');
        }else{
            $_SESSION['error'] = "Some error is coming to send activation email.";
        }
    }else{
        $_SESSION['error'] = "Email not found";
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
                                  <span class="breadcrumb-item active">Send Mail</span>
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
									<h2 class="title__line--6">Recover Your Password?</h2>
                                    <p>We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p><br>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="contact-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" placeholder="Enter your email*" style="width:100%" required>
										</div>
									</div>
									<div class="contact-btn">
										<button type="submit" name="submit" class="fv-btn">Send Mail</button>
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