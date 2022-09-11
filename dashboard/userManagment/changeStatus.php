<?php
include('../../config.php');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $user_id . "";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $current_Status = $user['active'];

        if ($current_Status == 1) {
            $query = "UPDATE " . $prefix . "_users SET active=0 WHERE user_id=" . $user_id . "";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
            header("location:../usersManagement.php");
        }
        if ($current_Status == 0) {
            $query = "UPDATE " . $prefix . "_users SET active=1 WHERE user_id=" . $user_id . "";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
            header("location:../usersManagement.php");
        }
    }
}
