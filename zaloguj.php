<?php
    session_start();

    if ((!isset($_POST['email'])) || (!isset($_POST['haslo']))){
        header("location:login.php");
        exit();
    }
    
    require_once("config.php");

    $email = $_POST['email'];
    $haslo = $_POST['haslo'];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");
	$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

    $query = sprintf("SELECT * FROM uzytkownicy WHERE email='%s' and haslo='%s'",
    mysqli_real_escape_string($link, $email),
    mysqli_real_escape_string($link, $haslo));
    
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    if(mysqli_num_rows($result)==1){
        $_SESSION['zalogowany'] = true;

        $wiersz=mysqli_fetch_assoc($result);
        $_SESSION['id']=$wiersz['id'];
        $_SESSION['imie']=$wiersz['imie'];
        $_SESSION['nazwisko']=$wiersz['nazwisko'];
        $_SESSION['typ_uzytkownika']=$wiersz['typ_uzytkownika'];

        unset($_SESSION['blad']);

        header("location:dashboard/index.php");
    }
    else{
        $_SESSION['blad'] = '<div class="alert alert-danger" role="alert">
        Użytkownik nie istnieje!
        </div>';
      header("location:login.php");
    }
    
?>