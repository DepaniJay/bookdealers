<?php
require('connection_inc.php');
include('functions_inc.php');

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $updatequery = "update authentication set status='1' where token='$token' ";
    $query = mysqli_query($con, $updatequery);

    if($query){
        if(isset($_SESSION['activate_msg'])){
            $_SESSION['activate_msg'] = "Account updated successfully";
            moveCurrentPageToOtherPage('login.php');
        }else{
            $_SESSION['activate_msg'] = "You are logged out.";
            moveCurrentPageToOtherPage('login.php');
        }
    }else{
        $_SESSION['activate_msg'] = "Account not updated";
        moveCurrentPageToOtherPage('register.php');
    }
}
?>