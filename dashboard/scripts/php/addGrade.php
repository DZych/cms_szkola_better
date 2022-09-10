<?php


$id_student = $_COOKIE["student_id"];
$subject_id = $_COOKIE["subject_id"];
$user_id = $_SESSION['user_id'];
$grade = $_COOKIE["grade"];
$type = $_COOKIE["type_grade"];

$query = "SELECT `teacher_id` FROM `_teachers` WHERE `user_id` = " . $user_id . "";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");


if (mysqli_num_rows($result) > 0) {
    foreach ($result as $teacher) {
        $query = "INSERT INTO `_grades` (`id_student`, `subject_id`, `teacher_id`, `grade`, `type`) 
        VALUES (" . $id_student . ", " . $subject_id . ", " . $teacher['teacher_id'] . ", " . $grade . ", " . $type . ");";
        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
        echo '<h5>Pomyślnie dodano ocenę. </h5>';
    };
};
