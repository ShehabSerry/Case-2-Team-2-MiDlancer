<?php
$localhost= "localhost";
$username= "root";
$password= "";
$database= "case2";
ob_start();

$connect=mysqli_connect($localhost,$username,$password,$database);
session_start();
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location:");
}
?>
