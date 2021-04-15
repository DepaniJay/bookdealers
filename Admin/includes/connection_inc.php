<?php
// start session
session_start();

// creare database connection 
$server = "remotemysql.com";
$username = "Rj2MJVsPdX";
$password = "I6Hu1DT8T8";
$db = "Rj2MJVsPdX";
$port = 3306;
$con = mysqli_connect($server,$username,$password,$db,$port);

// creare database connection 
// $server = "localhost";
// $username = "root";
// $password = "";
// $db = "book_dealers";

// $con = mysqli_connect($server,$username,$password,$db);



?>