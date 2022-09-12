<?php
session_start();
include("../../config.php");

    $user_id_delete = $_POST['delete_user_id'];

    $query = "DELETE FROM ".$prefix."._users WHERE user_id = ".$user_id_delete.";";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

    if(mysqli_affected_rows($link) == 1){
        $_SESSION['delete_message'] = '<div class="alert alert-success mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Konto zostało usunięte!</strong> 
        </div>';
    }
    else{
        $_SESSION['delete_message'] = '<div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Konto nie zostało usunięte!</strong> 
        </div>';
    }

    header("location:../usersManagement.php");

?>