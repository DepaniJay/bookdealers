<?php
require('top.php');
// prx($_SESSION);
if(!isset($_SESSION['firstname'])){
    moveCurrentPageToOtherPage('login.php');
}
$uid=$_SESSION['user_id'];

$res=mysqli_query($con,"select product.id,product.name,product.image,product.price,product.mrp from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'");

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
                                  <span class="breadcrumb-item active">Wishlist</span>
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
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($row=mysqli_fetch_assoc($res)){
                                        ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="product.php?id=<?php echo $row['id']; ?>"><img src="media/product/<?php echo $row['image']; ?>" alt="product img" /></a></td>
                                            <td class="product-name"><a href="#"><?php echo $row['name']; ?></a>
                                                <ul  class="pro__prize">
                                                    <li class="old__prize"><a href="#">₹<?php echo $row['mrp']; ?></li>
                                                    <li><a href="#">₹<?php echo $row['price']; ?></li>
                                                </ul>
                                            </td>
                                            <td class="product-price"><span class="amount">₹<?php echo $row['price']; ?></span></td>
                                            <td class="product-remove"><a href="wishlist.php?wishlist_id=<?php echo $row['id']; ?>"><i class="icon-trash icons"></i></a></td>
                                        </tr>
                                        <?php
                                         } 
                                        ?>
                                    </tbody>
                                </table>
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