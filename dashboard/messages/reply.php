<?php
session_start();

$_SESSION['subject'] = $_POST['subject'];
$_SESSION['date'] = $_POST['date'];
$_SESSION['receiver'] = $_POST['receiver_id'];
$_SESSION['content'] = $_POST['content'];
$_SESSION['content'] .= "<p>------- Poprzednia wiadomość -------</p>";
$_SESSION['content'] .= "<p>".$_POST['sender']."</p>";
$_SESSION['content'] .= "<p>".$_SESSION['date']."</p>";
$_SESSION['content'] .= "<hr><br>";

header("location:../newMessage.php");
?>