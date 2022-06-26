<?php
session_start();
$_SESSION['user_id']="";
$_SESSION['first_name']="";
$_SESSION['last_name']="";
session_destroy();
header("location:../../login.php");
?>