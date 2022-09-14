<?php
session_start();
include("../../config.php");

    // echo $_POST['first_name'];
    // echo '<br>';
    // echo $_POST['last_name'];
    // echo '<br>';
    // echo $_POST['password1'];
    // echo '<br>';
    // echo $_POST['password2'];
    // echo '<br>';
    // echo $_POST['Email'];
    // echo '<br>';
    // echo $_POST['phone'];
    // echo '<br>';
    // echo $_POST['birthday'];
    // echo '<br>';
    // echo $_POST['userType'];

    if ($_POST['password1'] === $_POST['password2']){
        if (isset($_POST["Email"])){
            if($_POST["Email"] != "" && $_POST['password2'] != "" && $_POST['password1'] != ""){
                
                $query = "INSERT INTO ".$prefix."._users (email, password, first_name, last_name, birth_date, date_of_join, phone, active)
                VALUES ( '".$_POST['Email']."', '".password_hash($_POST['password2'], PASSWORD_DEFAULT) ."', '".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['birthday']."', '".date('Y-m-d')."', '".$_POST['phone']."', '1');";
                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                $last_inserted_user_id = mysqli_insert_id($link);

                if($_POST['userType'] == "s"){
                    $query = "INSERT INTO ".$prefix."_students (user_id) VALUES ('".$last_inserted_user_id."');";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                }
                if($_POST['userType'] == "t"){
                    $query = "INSERT INTO ".$prefix."_teachers (user_id) VALUES ('".$last_inserted_user_id."');";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                }
                if($_POST['userType'] == "a"){
                    $query = "INSERT INTO ".$prefix."_admins (user_id) VALUES ('".$last_inserted_user_id."');";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                }
                
                $_SESSION['delete_message'] = '<div class="alert alert-success mt-2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Konto zostało pomyślnie dodane!</strong> 
                </div>';

                header("location:../usersManagement.php");
            }
        }
    }
    else{
        $_SESSION['changepswd'] = 2;
        header("location:../changeUserInfo.php?new-user");
    }
?>