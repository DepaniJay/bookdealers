<?php
include('includes/header.php');
include('includes/navbar.php');
isAdmin();
$coupon_code='';
$coupon_value='';
$coupon_type='';
$cart_min_value='';


if(isset($_GET['id']) && $_GET['id']!=''){

    $id = get_safe_value($con,$_GET['id']);
    $res = mysqli_query($con,"select * from coupon_master where id='$id'");
    $check=mysqli_num_rows($res);
    if($check>0){
        $categories_row = mysqli_fetch_assoc($res);
        
        $coupon_code = $categories_row['coupon_code'];
        $coupon_value = $categories_row['coupon_value'];
        $coupon_type = $categories_row['coupon_type'];
        $cart_min_value = $categories_row['cart_min_value'];
    }else{
        moveCurrentPageToOtherPage('coupon.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $coupon_code = get_safe_value($con,$_POST['coupon_code']);
    $coupon_value = get_safe_value($con,$_POST['coupon_value']);
    $coupon_type = get_safe_value($con,$_POST['coupon_type']);
    $cart_min_value = get_safe_value($con,$_POST['cart_min_value']);

    $res = mysqli_query($con,"select * from coupon_master where coupon_code='$coupon_code' ");
    $check=mysqli_num_rows($res);

    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData = mysqli_fetch_assoc($res);
            if($id==$getData['id']){

            } else{
                $_SESSION['error'] = "Coupon Code already exist";
            }
        }else{
            $_SESSION['error'] = "Coupon Code already exist";
        }
    }
    


    if($_SESSION['error']==''){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $update_sql = "UPDATE `coupon_master` SET `coupon_code`='$coupon_code',`coupon_value`='$coupon_value',`coupon_type`='$coupon_type',`cart_min_value`='$cart_min_value' WHERE id='$id'";
            mysqli_query($con,$update_sql);
        }else{
            $timestamp = get_current_time();
            mysqli_query($con,"INSERT INTO `coupon_master`(`coupon_code`, `coupon_value`, `coupon_type`, `cart_min_value`, `status`,`added_on`) VALUES ('$coupon_code','$coupon_value','$coupon_type','$cart_min_value','1','$timestamp')");
        }
        moveCurrentPageToOtherPage('coupon.php');
        die();
    }
}



?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Coupon Form</h1>
                    </div>


                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="coupon_code">Coupon Code</label>
                            <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Enter coupon code" value="<?php echo $coupon_code; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="coupon_value">Coupon Value</label>
                            <input type="text" name="coupon_value" class="form-control" id="coupon_value" placeholder="Enter coupon value" value="<?php echo $coupon_value; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="coupon_type">Coupon Type</label>
                            <select class="form-control" name="coupon_type" id="coupon_type" required>
                                <option class="bg-secondary text-white" value="">Select</option>
                                <?php
                                if($coupon_type=='Percentage'){
                                    ?>
                                        <option value="Percentage" selected>Percentage</option>
                                        <option value="Rupee">Rupee</option> 
                                    <?php
                                }elseif($coupon_type=='Rupee'){
                                    ?>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Rupee" selected>Rupee</option> 
                                    <?php
                                }else{
                                    ?>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Rupee">Rupee</option> 
                                    <?php
                                }
                                ?>
                                
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cart_min_value">Cart Min Value</label>
                            <input type="text" name="cart_min_value" class="form-control" id="cart_min_value" placeholder="Enter Cart Min Value" value="<?php echo $cart_min_value; ?>" required>
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

<?php

include('includes/footer.php');
include('includes/scripts.php');

?>

