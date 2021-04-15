<?php
include('includes/header.php');
include('includes/navbar.php');
isAdmin();
$categories='';

if(isset($_GET['id']) && $_GET['id']!=''){
    $id = get_safe_value($con,$_GET['id']);
    $categories_select_sql = "select * from categories where id='$id' ";
    $res = mysqli_query($con,$categories_select_sql);
    $check=mysqli_num_rows($res);
    if($check>0){
        $categories_row = mysqli_fetch_assoc($res);
        $categories = $categories_row['categories'];
    }else{
        moveCurrentPageToOtherPage('categories.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $categories = get_safe_value($con,$_POST['categories']);

    $categories_select_sql = "select * from categories where categories='$categories' ";
    $res = mysqli_query($con,$categories_select_sql);
    $check=mysqli_num_rows($res);

    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData = mysqli_fetch_assoc($res);
            if($id==$getData['id']){

            } else{
                $_SESSION['error'] = "Categories already exist";
            }
        }else{
            $_SESSION['error'] = "Categories already exist";
        }
    }
    
    if($_SESSION['error']==''){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $update_categories_sql = "update `categories` set categories='$categories' where id='$id'";
            mysqli_query($con,$update_categories_sql);
        }else{
            $insert_categories_sql = "insert into categories(categories,status) values('$categories','1')";
            mysqli_query($con,$insert_categories_sql);
        }
        moveCurrentPageToOtherPage('categories.php');
        die();
    }
}



?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Categories</h1>
                    </div>


                    <form action="" method="post">
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <input type="text" name="categories" class="form-control" id="categories" placeholder="Enter categories name" value="<?php echo $categories; ?>" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <div class="text-danger mt-3">
                        <?php 
                        if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        }
                        ?>
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