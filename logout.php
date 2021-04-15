<?php
session_start();
require('functions_inc.php');

unset($_SESSION['error']);
unset($_SESSION['activate_msg']);
unset($_SESSION['user_id']);
unset($_SESSION['firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['email']);
unset($_SESSION['mobile']);


// destroy all cookies to remove all cookies
setcookie('emailcookie','',time()-86400);
setcookie('passwordcookie','',time()-86400);

moveCurrentPageToOtherPage('index.php');

die();

?>