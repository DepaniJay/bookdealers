<?php
require('includes/connection_inc.php');
include('includes/functions_inc.php');

unset($_SESSION['ACTIVITY_ID']);
unset($_SESSION['ADMIN_LOGIN']);
unset($_SESSION['ADMIN_USERNAME']);
unset($_SESSION['name']);
unset($_SESSION['user_id']);
unset($_SESSION['admin_level']);

// destroy all cookies to remove all cookies
setcookie('emailcookie','',time()-86400);
setcookie('passwordcookie','',time()-86400);

moveCurrentPageToOtherPage('login.php');

die();

?>