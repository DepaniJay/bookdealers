<?php
include('includes/header.php');
include('includes/navbar.php');

$categories_id='';
$sub_categories_id='';
$name='';
$book_condition='';
$author='';
$name='';
$mrp='';
$price='';
$qty='';
$image='';
$short_desc='';
$description='';
$best_seller='';
$meta_title='';
$meta_desc='';
$meta_keyword='';

$timestamp=get_current_year();

$condition='';
$condition_product='';
if($_SESSION['admin_level']=='Admin'){
    $condition=" and product.added_by='".$_SESSION['user_id']."'";
    $condition_product=" and added_by='".$_SESSION['user_id']."'";
}

$image_required='required';

if(isset($_GET['id']) && $_GET['id']!=''){
    $image_required='';
    $id = get_safe_value($con,$_GET['id']);
    $categories_select_sql = "select * from product where id='$id' $condition_product";
    $res = mysqli_query($con,$categories_select_sql);
    $check=mysqli_num_rows($res);
    if($check>0){
        $categories_row = mysqli_fetch_assoc($res);
        
        $categories_id = $categories_row['categories_id'];
        $sub_categories_id = $categories_row['sub_categories_id'];
        $name = $categories_row['name'];
        $book_condition = $categories_row['book_condition'];
        $author = $categories_row['author'];
        $mrp = $categories_row['mrp'];
        $price = $categories_row['price'];
        $qty = $categories_row['qty'];
        $short_desc = $categories_row['short_desc'];
        $description = $categories_row['description'];
        $best_seller = $categories_row['best_seller'];
        $meta_title = $categories_row['meta_title'];
        $meta_desc = $categories_row['meta_desc'];
        $meta_keyword = $categories_row['meta_keyword'];
    }else{
        moveCurrentPageToOtherPage('product.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $categories_id = get_safe_value($con,$_POST['categories_id']);
    $sub_categories_id = get_safe_value($con,$_POST['sub_categories_id']);
    $name = get_safe_value($con,$_POST['name']);
    $book_condition = get_safe_value($con,$_POST['book_condition']);
    $author = get_safe_value($con,$_POST['author']);
    $mrp = get_safe_value($con,$_POST['mrp']);
    $price = get_safe_value($con,$_POST['price']);
    $qty = get_safe_value($con,$_POST['qty']);
    $short_desc = get_safe_value($con,$_POST['short_desc']);
    $description = get_safe_value($con,$_POST['description']);
    $best_seller = get_safe_value($con,$_POST['best_seller']);
    $meta_title = get_safe_value($con,$_POST['meta_title']);
    $meta_desc = get_safe_value($con,$_POST['meta_desc']);
    $meta_keyword = get_safe_value($con,$_POST['meta_keyword']);

    $categories_select_sql = "select * from product where name='$name' $condition_product";
    $res = mysqli_query($con,$categories_select_sql);
    $check=mysqli_num_rows($res);

    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData = mysqli_fetch_assoc($res);
            if($id==$getData['id']){

            } else{
                $_SESSION['error'] = "Product already exist";
            }
        }else{
            $_SESSION['error'] = "Product already exist";
        }
    }
    
    if($_FILES['image']['type']!='' && ($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')){
        $_SESSION['error'] = "Please selcet only png,jpg and jpeg image formate ";
    }

    if($_SESSION['error']==''){
        if(isset($_GET['id']) && $_GET['id']!=''){

            if($_FILES['image']['name']!=''){
                $image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],'../media/product/'.$image);

                $update_categories_sql = "UPDATE `product` SET `categories_id`='$categories_id',`name`='$name',`mrp`='$mrp',`price`='$price',`qty`='$qty',`image`='$image',`short_desc`='$short_desc',`description`='$description',`best_seller`='$best_seller',`meta_title`='$meta_title',`meta_desc`='$meta_desc',`meta_keyword`='$meta_keyword',`sub_categories_id`='$sub_categories_id',`book_condition`='$book_condition',`author`='$author' WHERE id='$id'";

            }else{

                $update_categories_sql = "UPDATE `product` SET `categories_id`='$categories_id',`name`='$name',`mrp`='$mrp',`price`='$price',`qty`='$qty',`short_desc`='$short_desc',`description`='$description',`best_seller`='$best_seller',`meta_title`='$meta_title',`meta_desc`='$meta_desc',`meta_keyword`='$meta_keyword',`sub_categories_id`='$sub_categories_id',`book_condition`='$book_condition',`author`='$author' WHERE id='$id'";
            }
            mysqli_query($con,$update_categories_sql);
        }else{
            $image = rand(111111111,999999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],'../media/product/'.$image);

            $insert_categories_sql = "INSERT INTO `product`(`categories_id`, `name`,`book_condition`,`author`, `mrp`, `price`, `qty`,`short_desc`, `description`,`best_seller`, `meta_title`, `meta_desc`, `meta_keyword`, `status`,`image`,`sub_categories_id`,`added_by`,`added_on`) VALUES ('$categories_id','$name','$book_condition','$author','$mrp','$price','$qty','$short_desc','$description','$best_seller','$meta_title','$meta_desc','$meta_keyword','1','$image','$sub_categories_id','".$_SESSION['user_id']."','$timestamp')";

            mysqli_query($con,$insert_categories_sql);
        }
        moveCurrentPageToOtherPage('product.php');
        die();
    }
}



?>

 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Products</h1>
                    </div>


                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <select class="form-control" name="categories_id" id="categories" onchange="get_sub_cat('')" required>
                                <option class="bg-secondary text-white">Select Category</option>
                                <?php
                                $res = mysqli_query($con,"select id,categories from categories order by categories asc");
                                while($row=mysqli_fetch_assoc($res)){
                                    if($row['id']==$categories_id){
                                        echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                    }else{
                                        echo "<option  value=".$row['id'].">".$row['categories']."</option>";
                                    }
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sub_categories">Sub Categories</label>
                            <select class="form-control" name="sub_categories_id" id="sub_categories" required>
                                <option class="bg-secondary text-white" value="">Select Sub Category</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="name" class="form-control" id="product_name" placeholder="Enter product name" value="<?php echo $name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="mrp">MRP</label>
                            <input type="text" name="mrp" class="form-control" id="mrp" placeholder="Enter product mrp" value="<?php echo $mrp; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="Enter product price" value="<?php echo $price; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" name="qty" class="form-control" id="qty" placeholder="Enter product qty" value="<?php echo $qty; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control" id="image" <?php echo $image_required; ?>/>
                        </div>

                        <div class="form-group">
                            <label for="author">Book Author Name</label>
                            <input type="text" name="author" class="form-control" id="author" placeholder="Enter Book author name" value="<?php echo $name; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="book_condition">Book Condition</label>
                            <select class="form-control" name="book_condition" id="book_condition" required>
                                <option class="bg-secondary text-white" value="">Select</option>
                                <?php
                                if($book_condition=='New'){
                                    ?>
                                        <option value="New" selected>New</option>
                                        <option value="Old">Old</option> 
                                    <?php
                                }elseif($book_condition=='Old'){
                                    ?>
                                        <option value="New">New</option>
                                        <option value="Old" selected>Old</option> 
                                    <?php
                                }else{
                                    ?>
                                        <option value="New">New</option>
                                        <option value="Old">Old</option> 
                                    <?php
                                }
                                ?> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="short_desc">Short Description</label>
                            <textarea name="short_desc" class="form-control" id="short_desc" placeholder="Enter product short description" required><?php echo $short_desc; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter product description" required><?php echo $description; ?></textarea>
                        </div>
                        
                        <?php
                        if($_SESSION['admin_level']!='Admin'){
                        ?>
                        <div class="form-group">
                            <label for="best_seller">Best Seller</label>
                            <select class="form-control" name="best_seller" id="best_seller" required>
                                <option class="bg-secondary text-white" value="">Select</option>
                                <?php
                                if($best_seller==1){
                                    ?>
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option> 
                                    <?php
                                }elseif($best_seller==0){
                                    ?>
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option> 
                                    <?php
                                }else{
                                    ?>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option> 
                                    <?php
                                }
                                ?>
                                
                            </select>
                        </div>
                        <?php 
                        }
                        ?>
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <textarea name="meta_title" class="form-control" id="meta_title" placeholder="Enter product meta title" ><?php echo $meta_title; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="meta_desc">Meta Description</label>
                            <textarea name="meta_desc" class="form-control" id="meta_desc" placeholder="Enter product meta description" ><?php echo $meta_desc; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="meta_keyword">Meta Keywords</label>
                            <textarea name="meta_keyword" class="form-control" id="meta_keyword" placeholder="Enter product meta keywords" ><?php echo $meta_keyword; ?></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <div class="text-danger mt-3">
                        <?php echo $_SESSION['error']; 
                        $_SESSION['error']='';?>
                        </div>
                    </form>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        <script>
            function get_sub_cat(sub_cat_id){
                var categories_id=jQuery('#categories').val();
                jQuery.ajax({
                    url:'get_sub_cat.php',
                    type:'post',
                    data:'categories_id='+categories_id+'&sub_cat_id='+sub_cat_id,
                    success:function(result){
                        jQuery('#sub_categories').html(result);
                    }
                });
            }
        </script>
<?php

include('includes/footer.php');
include('includes/scripts.php');

?>

<script>
<?php
    if(isset($_GET['id'])){
?>
    get_sub_cat('<?php echo $sub_categories_id; ?>');
<?php 
    } 
?>
</script>
