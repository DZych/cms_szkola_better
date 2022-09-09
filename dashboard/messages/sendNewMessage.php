<?php
session_start();
include("../../config.php");

if (isset($_POST['receiver']) && $_POST['content'] != null && $_POST['subject'] != null) {
    unset($_SESSION['message_error']);

    $receiver =  $_POST['receiver'];
    $subject =  $_POST['subject'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // Dodanie wiadomości do bazy
    $query = "INSERT INTO " . $prefix . "_messages (`receiver_id`, `sender_id`, `subject`, `content`, `date`, `deleted_by_sender`, `deleted_by_receiver`)
              VALUES ( '$receiver', '$user_id', '$subject', '$content', current_timestamp(), 0, 0);";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

    // Wyświetlenie statusu
    if ($result == true) {
        $_SESSION['message_error'] = '<div class="alert alert-success mt-4" role="alert">
                                    Wiadomość została wysłana!
                                  </div>';
        header("location:../newMessage.php");
    } else {
        $_SESSION['message_error'] = '<div class="alert alert-danger mt-4" role="alert">
                                    Wystąpił błąd, spróbuj wysłać wiadomość jeszcze raz!
                                  </div>';
        header("location:../newMessage.php");
    }
} else {
    if (isset($_POST['subject'])) {
        $_SESSION['subject'] = $_POST['subject'];
    }
    if (isset($_POST['content'])) {
        $_SESSION['content'] = $_POST['content'];
    }

    $_SESSION['message_error'] = '<div class="alert alert-danger mt-4" role="alert">
                                    Wszystkie pola muszą być wypełnione oraz odbiorca musi zostać wybrany!
                                  </div>';
    header("location:../newMessage.php");
}
