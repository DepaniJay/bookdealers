<?php
require('top.php');
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
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">shopping cart</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($_SESSION['cart']) && $_SESSION['cart']!=''){

                                        foreach($_SESSION['cart'] as $key=>$val){
                                            $productArr = get_product($con,'','',$key,'','');
                                            // pr($productArr);
                                            $pname = $productArr['0']['name'];
                                            $mrp = $productArr['0']['mrp'];
                                            $price = $productArr['0']['price'];
                                            $image = $productArr['0']['image'];
                                            $qty=$val['qty'];
                                        ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="media/product/<?php echo $image; ?>" alt="product img" /></a></td>
                                            <td class="product-name"><a href="#"><?php echo $pname; ?></a>
                                                <ul  class="pro__prize">
                                                    <li class="old__prize"><a href="#">₹<?php echo $mrp; ?></li>
                                                    <li><a href="#">₹<?php echo $price; ?></li>
                                                </ul>
                                            </td>
                                            <td class="product-price"><span class="amount">₹<?php echo $price; ?></span></td>
                                            <td class="product-quantity"><input type="number" id="<?php echo $key; ?>qty" value="<?php echo $qty; ?>" />
                                            <br>
                                            <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','update')">update</a>
                                            </td>
                                            <td class="product-subtotal">₹<?php echo $qty*$price; ?></td>
                                            <td class="product-remove"><a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="icon-trash icons"></i></a></td>
                                        </tr>
                                        <?php
                                         } 
                                        }
                                        ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="index.php">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                           
                                            <a href="checkout.php">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
        <!-- End Banner Area -->

<?php
require('footer.php');

?>