<?php
// start session
session_start();

// creare database connection 
$server = "localhost";
$username = "root";
$password = "";
$db = "book_dealers";

$con = mysqli_connect($server,$username,$password,$db);



?>