<?php
include('../../config.php');

$message_id = $_COOKIE["message_id"];

$query = "UPDATE ".$prefix."._messages SET deleted_by_sender = '1' WHERE message_id = '".$message_id."';";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

header("location:../sentMessage.php");
