<?php

require('top.php'); 
$_SESSION['error'] = '';

if(isset($_POST['submit'])){
    $email = get_safe_value($con,$_POST['email']);
    $password = get_safe_value($con,$_POST['password']);

    $selectquery = "select * from `authentication` where email='$email' and status='1' ";
    $query = mysqli_query($con,$selectquery);
    $count = mysqli_num_rows($query);

    if($count){
        // fetch password from database 
        $email_pass = mysqli_fetch_assoc($query);
        $db_pass = $email_pass['password'];

        // user enter password and database password is same or not verify by password_verify function
        $pass_decode = password_verify($password, $db_pass);
        
        if($pass_decode){
            $_SESSION['firstname'] = $email_pass['firstname'];
            $_SESSION['user_id']= $email_pass['id'];
            $_SESSION['lastname'] = $email_pass['lastname'];
            $_SESSION['email'] = $email_pass['email'];
            $_SESSION['mobile'] = $email_pass['mobile'];

                if(isset($_POST['rememberme'])){
                    setcookie('emailcookie',$email,time()+86400);
                    setcookie('passwordcookie',$password,time()+86400);
                    if(isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID']!=''){
                        wishlist_add($con,$_SESSION['user_id'],$_SESSION['WISHLIST_ID']);
                        unset($_SESSION['WISHLIST_ID']);
                    }
                    moveCurrentPageToOtherPage('index.php');
                }else{
                    if(isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID']!=''){
                        wishlist_add($con,$_SESSION['user_id'],$_SESSION['WISHLIST_ID']);
                        unset($_SESSION['WISHLIST_ID']);
                    }
                    moveCurrentPageToOtherPage('index.php');
                }
        }else{
            $_SESSION['error'] = "Password is not matching";
        }
    }else{
        $_SESSION['error'] = "Email does not exist";
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
                                  <span class="breadcrumb-item active">Login</span>
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
									<h2 class="title__line--6">Welcome Back!</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="contact-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
									
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" value="
                                                <?php 
                                                if(isset($_COOKIE['emailcookie'])){
                                                    echo $_COOKIE['emailcookie'];
                                                } 
                                                ?>
                                                " placeholder="Enter your email*" style="width:100%">
										</div>
									</div>
									<div class="single-contact-form">
                                        <div class="contact-box name">
                                            <input type="password" name="password" value="<?php if(isset($_COOKIE['passwordcookie'])){echo $_COOKIE['passwordcookie'];}  ?>" placeholder="Your password*" style="width:100%">
                                        </div>
									</div>
                                    <br>
									<div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="rememberme" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label " for="customCheck">&nbsp;Remember Me</label>
                                    </div>
									<div class="contact-btn">
										<button type="submit" name="submit" class="fv-btn">Login Now</button>
									</div>
								</form>
                                    <hr>
                                    <!-- this code for print error  -->
                                    <div class="text-center text-danger small"><?php echo $_SESSION['error'];  ?></div>
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
                                    <br>
                                    <h5>
                                        <div class="text-center">
                                            <a class="small" href="recover_email.php">Forgot Password?</a>
                                        </div>
                                        <br>
                                        <div class="text-center">
                                            <a class="small" href="register.php">Create an Account!</a>
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