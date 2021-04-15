<?php
require('connection_inc.php');
require('functions_inc.php');

if(!isset($_SESSION['firstname'])){
    moveCurrentPageToOtherPage('login.php');
}

$password=get_safe_value($con,$_POST['password']);
$newpassword=get_safe_value($con,$_POST['newpassword']);
$uid=$_SESSION['user_id'];

$pass = password_hash($newpassword, PASSWORD_BCRYPT);
$row=mysqli_fetch_assoc(mysqli_query($con,"select password from `authentication` where id='$uid'"));
$pass_decode = password_verify($password, $row['password']);

if($pass_decode){
    mysqli_query($con,"update `authentication` set password='$pass' where id='$uid'");
    echo "Your password updated successfully";
}else{
    echo "Please enter your current valide password";
}   

?>