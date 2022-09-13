<?php
$grade = $_COOKIE["gradeSelected"];
$query = "DELETE FROM " . $prefix . "_grades
WHERE id = " . $grade . ";";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
$_POST['showTableBtn'] = 1;
$_POST["selected_class"] = $_SESSION['last_selected_class_id'];
$_POST["selected_subject"] = $_SESSION['last_selected_subject_id'];
