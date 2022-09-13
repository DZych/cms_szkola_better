<?php


$id_student = $_COOKIE["student_id"];
$subject_id = $_COOKIE["subject_id"];
$user_id = $_SESSION['user_id'];
$grade = $_COOKIE["grade"];
$type = $_COOKIE["type_grade"];

$query = "SELECT `teacher_id` FROM " . $prefix . "`_teachers` WHERE `user_id` = " . $user_id . "";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");


if (mysqli_num_rows($result) > 0) {
    foreach ($result as $teacher) {
        $query = "INSERT INTO " . $prefix . "`_grades` (`id_student`, `subject_id`, `teacher_id`, `grade`, `type`) 
        VALUES (" . $id_student . ", " . $subject_id . ", " . $teacher['teacher_id'] . ", " . $grade . ", " . $type . ");";
        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
        $_POST['showTableBtn'] = 1;
        $_POST["selected_class"] = $_SESSION['last_selected_class_id'];
        $_POST["selected_subject"] = $_SESSION['last_selected_subject_id'];
    };
};
