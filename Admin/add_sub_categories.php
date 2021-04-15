<?php
include('includes/header.php');
include('includes/navbar.php');
isAdmin();
$categories='';
$sub_categories='';

if(isset($_GET['id']) && $_GET['id']!=''){
    $id = get_safe_value($con,$_GET['id']);
    $categories_select_sql = "select * from sub_categories where id='$id' ";
    $res = mysqli_query($con,$categories_select_sql);
    $check=mysqli_num_rows($res);
    if($check>0){
        $categories_row = mysqli_fetch_assoc($res);
        $categories = $categories_row['categories_id'];
        $sub_categories = $categories_row['sub_categories'];
    }else{
        moveCurrentPageToOtherPage('sub_categories.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $categories = get_safe_value($con,$_POST['categories_id']);
    $sub_categories = get_safe_value($con,$_POST['sub_categories']);

    $categories_select_sql = "select * from `sub_categories` where categories_id='$categories' and sub_categories='$sub_categories' ";
    $res = mysqli_query($con,$categories_select_sql);
    $check=mysqli_num_rows($res);

    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $getData = mysqli_fetch_assoc($res);
            if($id==$getData['id']){

            } else{
                $_SESSION['error'] = "Sub Categories already exist";
            }
        }else{
            $_SESSION['error'] = "Sub Categories already exist";
        }
    }
    
    if($_SESSION['error']==''){
        if(isset($_GET['id']) && $_GET['id']!=''){
            $update_categories_sql = "update `sub_categories` set categories_id='$categories',sub_categories='$sub_categories' where id='$id'";
            mysqli_query($con,$update_categories_sql);
        }else{
            $insert_categories_sql = "insert into sub_categories(categories_id,sub_categories,status) values('$categories','$sub_categories','1')";
            mysqli_query($con,$insert_categories_sql);
        }
        moveCurrentPageToOtherPage('sub_categories.php');
        die();
    }
}



?>
 
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add Sub Categories</h1>
                    </div>


                    <form action="" method="post">

                        <label for="categories">Categories</label>
                        <select class="form-control" name="categories_id" id="categories" required>
                            <option class="bg-secondary text-white">Select Category</option>
                            <?php
                            $res = mysqli_query($con,"select * from categories where status='1' order by categories asc");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$categories){
                                    echo "<option  value=".$row['id']." selected>".$row['categories']."</option>";
                                }else{
                                    echo "<option  value=".$row['id'].">".$row['categories']."</option>";
                                }
                            } 
                            ?>
                        </select>
                        <br>
                        <div class="form-group">
                            <label for="sub_categories">Sub Categories</label>
                            <input type="text" name="sub_categories" class="form-control" id="sub_categories" placeholder="Enter sub categories name" value="<?php echo $sub_categories; ?>" required>
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