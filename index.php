<?php
require('top.php');

// prx($_SESSION);

?>

        </div>
        <!-- End Offset Wrapper -->

        <!-- Start Slider Area -->
        <div class="slider__container slider--one bg__cat--3">
            <div class="slide__container slider__activation__wrap owl-carousel">
            <?php
            $best_seller=best_seller($con,'');
            foreach($best_seller as $list){
            ?>
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>Collection <?php
                                        $get_data_details=get_data_details($list['added_on'],'year','','','','','');
                                        echo $get_data_details-1;
                                        ?></h2>
                                        <h1 ><?php echo $list['name']; ?></h1>
                                        <div class="cr__btn">
                                            <a href="product.php?id=<?php echo $list['id']; ?>">Buy Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="media/product/<?php echo $list['image']; ?>" width="628" height="472" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- End Single Slide -->
            </div>
        </div>
        <!-- Start Slider Area -->

        

        <!-- Start Category Area -->
        <section class="htc__category__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Arrivals</h2>
                            <p>Letest Books for you start buying or selling using our website and grow your buisness</p>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30">
                            <?php
                                $get_product=get_product($con,8);
                                foreach($get_product as $list){
                            ?>
                            <!-- Start Single Category -->
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']; ?>">
                                            <img src="media/product/<?php echo $list['image'];?>" width="290" height="385" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']; ?>','add')"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="javascript:void(0)" onclick="manage_cart_index('<?php echo $list['id']; ?>','1','add')"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html"><?php 
                                        if(strlen($list['name'])>27){
                                            echo substr($list['name'],0,27).'...'; 
                                        }else{
                                            echo substr($list['name'],0,27); 
                                        }
                                        ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize">₹<?php echo $list['mrp'];?></li>
                                            <li>₹<?php echo $list['price'];?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
                           <?php
                            }
                           ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Category Area -->

        <!-- Start Product Area -->
        <section class="ftr__product__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Best Seller</h2>
                            <p>I provide you best selling books for seller easy to grow your buisness and for buyer easy to find most selling books for you</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix">
                    <?php
                                $get_product=get_product($con,8,'','','','','yes');
                                foreach($get_product as $list){
                            ?>
                            <!-- Start Single Category -->
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']; ?>">
                                            <img src="media/product/<?php echo $list['image'];?>" width="290" height="385" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']; ?>','add')"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="javascript:void(0)" onclick="manage_cart_index('<?php echo $list['id']; ?>','1','add')"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html"><?php 
                                        if(strlen($list['name'])>27){
                                            echo substr($list['name'],0,27).'...'; 
                                        }else{
                                            echo substr($list['name'],0,27); 
                                        } ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize">₹<?php echo $list['mrp'];?></li>
                                            <li>₹<?php echo $list['price'];?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
                           <?php
                            }
                           ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Area -->


         <!-- Start Product Area -->
         <section class="ftr__product__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Books</h2>
                            <p>This books is new in terms of book condition. i means book is new not seconed hand.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix">
                    <?php
                                $get_new_books_index=get_new_books_index($con,8);
                                foreach($get_new_books_index as $list){
                            ?>
                            <!-- Start Single Category -->
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']; ?>">
                                            <img src="media/product/<?php echo $list['image'];?>" width="290" height="385" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']; ?>','add')"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="javascript:void(0)" onclick="manage_cart_index('<?php echo $list['id']; ?>','1','add')"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html"><?php 
                                        if(strlen($list['name'])>27){
                                            echo substr($list['name'],0,27).'...'; 
                                        }else{
                                            echo substr($list['name'],0,27); 
                                        } ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize">₹<?php echo $list['mrp'];?></li>
                                            <li>₹<?php echo $list['price'];?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
                           <?php
                            }
                           ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Area -->

        <!-- Start Product Area -->
        <section class="ftr__product__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Old Books</h2>
                            <p>This books is old in terms of book condition. i means book is old seconed handed.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix">
                    <?php
                                $get_old_books_index=get_old_books_index($con,8);
                                foreach($get_old_books_index as $list){
                            ?>
                            <!-- Start Single Category -->
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']; ?>">
                                            <img src="media/product/<?php echo $list['image'];?>" width="290" height="385" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']; ?>','add')"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="javascript:void(0)" onclick="manage_cart_index('<?php echo $list['id']; ?>','1','add')"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html"><?php 
                                        if(strlen($list['name'])>27){
                                            echo substr($list['name'],0,27).'...'; 
                                        }else{
                                            echo substr($list['name'],0,27); 
                                        } ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize">₹<?php echo $list['mrp'];?></li>
                                            <li>₹<?php echo $list['price'];?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
                           <?php
                            }
                           ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Area -->

<?php
include('footer.php');

?>