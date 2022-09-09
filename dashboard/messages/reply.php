<?php
session_start();

$_SESSION['subject'] = $_POST['subject'];
$_SESSION['content'] = $_POST['content'];
$_SESSION['date'] = $_POST['date'];
$_SESSION['content'] .= "<p>------- Poprzednia wiadomość -------</p>";
$_SESSION['content'] .= "<p>".$_POST['sender']."</p>";
$_SESSION['content'] .= "<p>".$_SESSION['date']."</p>";
$_SESSION['content'] .= "<hr><br>";
$_SESSION['receiver'] = $_POST['receiver_id'];

header("location:../newMessage.php");
?>