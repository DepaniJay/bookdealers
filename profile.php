<?php
require('top.php');

if(!isset($_SESSION['firstname'])){
    moveCurrentPageToOtherPage('login.php');
}
?>
       
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
                                  <span class="breadcrumb-item active">Profile</span>
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
									<h2 class="title__line--6">My Profile</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="contact-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
									<div class="single-contact-form">
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="text" name="firstname" id="firstname" placeholder="Your first name*" style="width:100%" value="<?php echo $_SESSION['firstname']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="text" name="lastname" id="lastname" placeholder="Your last name*" style="width:100%" value="<?php echo $_SESSION['lastname']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" id="email" placeholder="Enter your email*" style="width:100%" value="<?php echo $_SESSION['email']; ?>" disabled>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="number" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%" value="<?php echo $_SESSION['mobile']; ?>" required>
										</div>
									</div>
									
									<div class="contact-btn">
										<button type="submit" onclick="update_profile()" id="btn_update_profile" name="submit" class="fv-btn">Update Profile</button>
									</div>
								</form>
                                <hr>
                                <h5 class="text-center text-danger ">
                                    <span class="text-danger text-center" id="error"></span>
                                </h5>
							</div>
                        </div>
				</div>
                <div class="row">
					<div class="col-md-12">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Change Password</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" id="update_password_form" method="post">
                                    <div class="single-contact-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="contact-box name">
                                                    <input type="password" name="password" id="password" placeholder="Current password*" style="width:100%" >
                                                </div>
                                            </div>
                                        </div>
									</div>
                                    <div class="single-contact-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="password" name="newpassword" id="newpassword" placeholder="New password*" style="width:100%" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="contact-box name">
                                                    <input type="password" name="newcpassword" id="newcpassword" placeholder="Confirm password*" style="width:100%" >
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="contact-btn">
										<button type="submit" onclick="update_password()" id="btn_update_password" name="submit_password" class="fv-btn">Update Password</button>
									</div>
								</form>
                                <hr>
                                <h5 class="text-center text-danger ">
                                    <span class="text-danger text-center" id="error_password"></span>
                                </h5>
							</div>
                        </div>
				</div>	
            </div>
        </section>
        <!-- End Contact Area -->
        <script>
            function update_profile(){
                jQuery('#error').html('');   
                var firstname=jQuery('#firstname').val();
                var lastname=jQuery('#lastname').val();
                var mobile=jQuery('#mobile').val();

                if(firstname==''){
                    jQuery('#error').html('Please enter firstname');
                }else if(lastname==''){
                    jQuery('#error').html('Please enter lastname');
                }else if(mobile==''){
                    jQuery('#error').html('Please enter Mobile number');
                }else{
                    jQuery('#btn_update_profile').html('Please wait...');
                    jQuery('#btn_update_profile').attr('disabled',true);
                    jQuery.ajax({
                        url:'update_profile.php',
                        type:'post',
                        data:'firstname='+firstname+'&lastname='+lastname+'&mobile='+mobile,
                        success:function(result){
                            jQuery('#error').html(result);
                            jQuery('#btn_update_profile').html('update');
                            jQuery('#btn_update_profile').attr('disabled',false);
                        }
                    });

                }
            }
            function update_password(){
                jQuery('#error_password').html('');   
                var password=jQuery('#password').val();
                var newpassword=jQuery('#newpassword').val();
                var newcpassword=jQuery('#newcpassword').val();
                var is_error='';

                if(password==''){
                    jQuery('#error_password').html('Please enter current password');
                    is_error="yes";
                }else if(newpassword==''){
                    jQuery('#error_password').html('Please enter new password');
                    is_error="yes";
                }else if(newcpassword==''){
                    jQuery('#error_password').html('Please enter confirm password');
                    is_error="yes";
                }else if(newpassword!=newcpassword){
                    jQuery('#error_password').html('Please enter same password');
                    is_error="yes";
                }

                if(is_error==''){
                    jQuery('#btn_update_password').html('Please wait...');
                    jQuery('#btn_update_password').attr('disabled',true);
                    jQuery.ajax({
                        url:'update_password.php',
                        type:'post',
                        data:'password='+password+'&newpassword='+newpassword,
                        success:function(result){
                            jQuery('#error_password').html(result);
                            jQuery('#btn_update_password').html('update');
                            jQuery('#btn_update_password').attr('disabled',false);
                            jQuery('#update_password_form')[0].reset();
                        }
                    });
                }
            }
        </script>

<?php
require('footer.php');
?>