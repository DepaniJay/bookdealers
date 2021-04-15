<?php
// start session
session_start();

// creare database connection 
$server = "localhost";
$username = "root";
$password = "";
$db = "book_dealers";

$con = mysqli_connect($server,$username,$password,$db);

define('SITE_PATH','http://localhost/Book%20Dealers/');




?>