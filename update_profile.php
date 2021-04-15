<?php
require('connection_inc.php');
require('functions_inc.php');

if(!isset($_SESSION['firstname'])){
    moveCurrentPageToOtherPage('login.php');
}

$firstname=get_safe_value($con,$_POST['firstname']);
$lastname=get_safe_value($con,$_POST['lastname']);
$mobile=get_safe_value($con,$_POST['mobile']);

$uid=$_SESSION['user_id'];

mysqli_query($con,"update `authentication` set firstname='$firstname',lastname='$lastname',mobile='$mobile' where id='$uid'");
$_SESSION['firstname']=$firstname;
$_SESSION['lastname']=$lastname;
$_SESSION['mobile']=$mobile;
echo "Your profile updated successfully";
?>