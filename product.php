<?php
require('top.php');
$product_id=get_safe_value($con,$_GET['id']);
$get_product=get_product($con,'','',$product_id);
$msg='';
$uid=$_SESSION['user_id'];
if(isset($_POST['submit'])){
    $rating=get_safe_value($con,$_POST['rating']);
    $message=get_safe_value($con,$_POST['message']);

    $res=mysqli_num_rows(mysqli_query($con,"select * from rating where user_id=$uid and product_id='$product_id'"));
    if($res>0){
        $msg="You have already submited your review.";
    }else{
        $timestamp=get_current_time();
        mysqli_query($con,"insert into rating(user_id,product_id,rating,review,added_on) values('$uid','$product_id','$rating','$message','$timestamp')");
        $msg="Your Review is submited";
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
                                  <a class="breadcrumb-item" href="categories.php?id=<?php echo $get_product['0']['categories_id']; ?>"><?php echo $get_product['0']['categories']; ?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active"><?php echo $get_product['0']['name']; ?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="media/product/<?php echo $get_product['0']['image']; ?>" width="300" height="500" alt="product-image">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name']; ?></h2><br>
                                <?php
                                $rating_calculation=rating_calculation($con,$product_id);
                                ?>
                                <div class=" m-3">
                                    <h3 class="badge badge-success" style="font-size:25px;"><?php echo $rating_calculation; ?>&nbsp;&nbsp;<i class="fa fa-star"></i></h3>
                                    <?php
                                    $total_rating_and_reviews=total_rating_and_reviews($con,$product_id);
                                    $rating=0;
                                    $review=0;
                                    foreach($total_rating_and_reviews as $list){
                                        if($list['rating']>0){
                                            $rating++;
                                        }
                                        if($list['review']!=''){
                                            $review++;
                                        }
                                    }
                                    ?>
                                    <span style="font-size:20px;">&nbsp;&nbsp;&nbsp;<?php echo $rating; ?> Ratings & <?php echo $review; ?> Reviews</span>
                                </div>
                                <div class="my-3">
                                    <ul  class="pro__prize">
                                        <li><h2>₹<?php echo $get_product['0']['price']; ?></h2></li>&nbsp;&nbsp;
                                        <li class="old__prize">₹<?php echo $get_product['0']['mrp']; ?></li>&nbsp;&nbsp;
                                        <li><?php 
                                        $discount= round(100*($get_product['0']['mrp']-$get_product['0']['price'])/$get_product['0']['mrp']);
                                        echo $discount.'% off';
                                        ?></li>
                                    </ul>
                                </div>
                                <div>
                                    <p class="pro__info"><?php echo $get_product['0']['short_desc']; ?></p>
                                </div>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
                                        <?php 
                                        $cart_show='yes';
                                        $productSoldQtyByProductId=productSoldQtyByProductId($con,$product_id);

                                        $pending_qty=$get_product['0']['qty']-$productSoldQtyByProductId;

                                        if($get_product['0']['qty']>$productSoldQtyByProductId){
                                            $stock='In Stock';
                                        }else{
                                            $stock='Not in Stock';
                                            $cart_show='';
                                        }
                                        ?>
                                        <p><span>Availability:</span>&nbsp;<?php echo $stock; ?></p>
                                    </div>
                                    <div class="sin__desc">
                                        <?php
                                        if($cart_show!=''){
                                        ?>
                                        <p><span>Qty:</span> 
                                        <select id="qty">
                                            <?php 
                                            for($i=1;$i<=$pending_qty;$i++){
                                                if($i<=10){
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }else{
                                                    break;
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                        </p>
                                        <?php } ?>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="categories.php?id=<?php echo $get_product['0']['categories_id']; ?>"><?php echo $get_product['0']['categories']; ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Author:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['author']; ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Book Condition:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['book_condition']; ?></a></li>
                                        </ul>
                                    </div>
                                    <br>
                                    <?php
                                    if($cart_show!=''){
                                    ?>
                                    <div class="fr__list__btn">
                                        <a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']; ?>','add')">Add To Cart</a>
                                    </div>
                                    <?php } ?>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <?php
                    if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="contact-form-wrap mt--60">
                                <div class="col-xs-12">
                                    <div class="contact-title">
                                        <h2 class="title__line--6">Give Rating and Riviews for this product</h2>
                                        <h4 class="text-success text-center"><?php echo $msg;
                                        $msg='';
                                        ?></h4><br>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <form action="" method="POST">
                                        <div class="single-contact-form">
                                            <div class="contact-box ">
                                                <select class="" name="rating" id="rating">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="single-contact-form">
                                            <div class="contact-box message">
                                                <textarea  name="message" placeholder="Write your reviews"></textarea>
                                            </div>
                                        </div>
                                        <div class="contact-btn">
                                            <button type="submit" name="submit" class="fv-btn">Submit Reviews</button>
                                        </div>
                                    </form>
                                
                                </div>
                            </div> 
                        </div>

                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area -->
        <!-- Start Product Description -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                <?php echo $get_product['0']['description']; ?>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Description -->

        <div class="container">
            <div class="">
                <h1>Reviews</h1>
            </div>
            <br>
            <?php
            $get_review_details=get_review_details($con,$uid,$product_id,3);
            foreach($get_review_details as $list){
            ?>

            <div>
                <div>
                    <h3 class="badge badge-success" style="font-size:20px;"><?php echo $list['rating']; ?>&nbsp;&nbsp;<i class="fa fa-star"></i></h3>
                </div>
                <div class="">
                    <p><?php echo $list['review']; ?></p>
                </div>
                <div class="">
                    <span><?php echo $list['firstname'].' '.$list['lastname']; ?></span>&nbsp;&nbsp;
                    <span>
                        <?php
                        $get_data_details=get_data_details($list['added_on'],'yes','yes','yes','','','');
                        echo $get_data_details;
                        ?>
                    </span>
                </div>
            </div>
            <br>
            <br>
            <?php
            }
            ?>
            <div class="m-5">
                <a href="#">All <?php 
                if($review>2){
                    echo $review-3; 
                }else{
                    echo $review; 
                }
                ?> Reviews</a>
            </div>
        </div>
        <br/>
        <br/>

        
        <!-- Start Product Area -->
<?php
include('footer.php');

?>