

<!-- Start Footer Area -->
<footer id="htc__footer">
            <!-- Start Footer Widget -->
            <div class="footer__container bg__cat--1">
                <div class="container">
                    <div class="row">
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="footer text-center">
                                <h2 class="title__line--2">ABOUT US</h2>
                                <div class="ft__details">
                                    <div>
                                        <img  width="300" height="250" style="border-radius:50%;" src="media/profile/jay.jpg" alt="Developer Image">
                                        <div>
                                            <h2 class="title__line--2" style="font-size:2rem;margin-top:20px;">Jay Depani</h2>
                                        </div>
                                    </div>
                                    <p>Hello, I am full stack developer. I create this website for Senior student or faculty or any person are sharing new/old and unused book with needed community.</p>
                                    <div class="ft__social__link ">
                                        <ul class="social__link text-center">
                                            <li><a href="https://twitter.com/home?lang=en" target="_blank"><i class="icon-social-twitter icons"></i></a></li>

                                            <li><a href="https://www.instagram.com/jd_27_9/" target="_blank"><i class="icon-social-instagram icons"></i></a></li>

                                            <li><a href="https://www.facebook.com/profile.php?id=100026669527816" target="_blank"><i class="icon-social-facebook icons"></i></a></li>

                                            <li><a href="https://github.com/DepaniJay" target="_blank"><i class="icon-social-github icons"></i></a></li>

                                            <li><a href="https://www.linkedin.com/feed/" target="_blank"><i class="icon-social-linkedin icons"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40">
                            <div class="footer">
                                <h2 class="title__line--2">Categories</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <?php $get_categories_name=get_categories_name($con);
                                        foreach($get_categories_name as $list){
                                        ?>
                                        <li><a href="categories.php?id=<?php echo $list['id']; ?>"><?php echo $list['categories']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->

                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40">
                            <div class="footer">
                                <h2 class="title__line--2">New Arrivals</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <?php $new_product=new_product($con,'8');
                                        foreach($new_product as $list){
                                        ?>
                                        <li><a href="product.php?id=<?php echo $list['id']; ?>"><?php echo $list['name']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->

                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40">
                            <div class="footer">
                                <h2 class="title__line--2">Best Seller</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <?php $best_seller=best_seller($con,'8');
                                        foreach($best_seller as $list){
                                        ?>
                                        <li><a href="product.php?id=<?php echo $list['id']; ?>"><?php echo $list['name']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->

                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40 smt-40">
                            <div class="footer">
                                <h2 class="title__line--2">Our service</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                        <?php
                                        if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
                                            ?>
                                            <li><a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>">My Profile</a></li>
                                            <li><a href="cart.php">My Cart</a></li>
                                            <li><a href="my_order.php?id=<?php echo $_SESSION['user_id']; ?>">My Orders</a></li>
                                            <li><a href="login.php">Login</a></li>
                                            <li><a href="wishlist.php?id=<?php echo $_SESSION['user_id']; ?>">Wishlist</a></li>
                                            <li><a href="checkout.php?id=<?php echo $_SESSION['user_id']; ?>">Checkout</a></li>
                                            <?php
                                        }else{
                                            ?>
                                            <li><a href="profile.php">My Profile</a></li>
                                            <li><a href="cart.php">My Cart</a></li>
                                            <li><a href="my_order.php">My Orders</a></li>
                                            <li><a href="login.php">Login</a></li>
                                            <li><a href="wishlist.php">Wishlist</a></li>
                                            <li><a href="checkout.php">Checkout</a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        
                    </div>
                </div>
            </div>
            <!-- End Footer Widget -->
            <!-- Start Copyright Area -->
            <div class="htc__copyright bg__cat--5">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="copyright__inner">
                                <p>Copyright© <a href="#">Book Dealers</a> <?php echo date('Y'); ?>. All right reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Copyright Area -->
        </footer>
        <!-- End Footer Style -->
    </div>
    <!-- Body main wrapper end -->

    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>
    
    <script src="js/custom.js"></script>

</body>

</html>