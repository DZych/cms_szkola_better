<?php
session_start();
$_SESSION['user_id']="";
$_SESSION['first_name']="";
$_SESSION['last_name']="";
$_SESSION['is_admin'] = false;
$_SESSION['is_teacher'] = false;
$_SESSION['is_student'] = false;
session_destroy();
header("location:../../login.php");
?>