<?php
$numer_lekcji2 =  $_COOKIE["numer_lekcji2"];
$dzien_tygodnia = $_COOKIE["dzien_tygodnia"];
$teacher_subject_id = $_COOKIE["teacher_subject_id"];
$class_id = $_COOKIE["class_id"];

$query = "INSERT INTO `_timetable` (`day`, `lesson_number`, `class_id`, `teacher_subject_id`)
            VALUES ('$dzien_tygodnia', '$numer_lekcji2', '$class_id', '$teacher_subject_id');";

$result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

?>