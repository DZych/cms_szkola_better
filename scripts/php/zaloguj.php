<?php
    session_start();

    if ((!isset($_POST['email'])) || (!isset($_POST['haslo']))){
        header("location:../../login.php");
        exit();
    }
    
    require_once("../../config.php");

    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['haslo']);


    $query = "SELECT * FROM ".$prefix."_users WHERE email='$email'";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    if(mysqli_num_rows($result)==1){
        $_SESSION['zalogowany'] = true;
        
        $wiersz=mysqli_fetch_assoc($result);

        if(password_verify($password, $wiersz['password'])){
        $_SESSION['user_id']=$wiersz['user_id'];
        $_SESSION['first_name']=$wiersz['first_name'];
        $_SESSION['last_name']=$wiersz['last_name'];

        $query = "UPDATE ".$prefix."_users SET `last_login_date` = current_timestamp(), `last_login_ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `user_id` = '".$wiersz['user_id']."';";
        mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");


        set_type_user("admins", "is_admin");
        set_type_user("teachers", "is_teacher");
        set_type_user("students", "is_student");
        
        unset($_SESSION['error']);
        header("location:../../dashboard/index.php");
        }
        else{
            $_SESSION['zalogowany'] = false;
            $_SESSION['error'] = '<div class="alert alert-danger" role="alert">
            Użytkownik nie istnieje!
            </div>';
          header("location:../../login.php");
        }
    }
    else{
        $_SESSION['zalogowany'] = false;
        $_SESSION['error'] = '<div class="alert alert-danger" role="alert">
        Użytkownik nie istnieje!
        </div>';
      header("location:../../login.php");
    }
      
    function set_type_user($table_name, $value_name){
        include("../../config.php");
        $query = "SELECT * FROM ".$prefix."_".$table_name." WHERE user_id =".$_SESSION['user_id'].";";
        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        if(mysqli_num_rows($result)==1){
            $_SESSION[$value_name] = true;
        }
        else{
            $_SESSION[$value_name] = false;
        }
    }
?>