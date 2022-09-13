<?php
session_start();
include("../../config.php");
if (isset($_POST['delete_class_id'])) {
    $class_id_to_delete = $_POST['delete_class_id'];

    // 1. Usuwanie wszystkiego z _student_class
    $query = "DELETE FROM " . $prefix . "_student_class WHERE student_class_id in (SELECT student_class_id FROM (SELECT * FROM " . $prefix . "_student_class) as sc WHERE sc.class_id='" . $class_id_to_delete . "');";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

    if ($result) {
        // 2. Usuwanie wszystkiego z _files
        $query = "DELETE FROM " . $prefix . "_files WHERE file_id in (SELECT file_id FROM " . $prefix . "_class_lessons_files WHERE class_lesson_id in (SELECT class_lesson_id FROM " . $prefix . "_class_lessons WHERE class_id ='" . $class_id_to_delete . "'));";
        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

        if ($result) {
            // 3. Usuwanie wszystkich połącznie z _class_lessons_files
            $query = "DELETE FROM " . $prefix . "_class_lessons_files WHERE class_lesson_files_id in (SELECT class_lesson_files_id FROM (SELECT * FROM " . $prefix . "_class_lessons_files) as sc WHERE sc.class_lesson_id in (SELECT class_lesson_id FROM " . $prefix . "_class_lessons WHERE class_id = '" . $class_id_to_delete . "'));";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

            if ($result) {
                // 4. Usuwanie wszystkiego z timetable
                $query = "DELETE FROM " . $prefix . "_timetable WHERE timetable_id in (SELECT timetable_id FROM (SELECT * FROM " . $prefix . "_timetable) as sc WHERE sc.class_lesson_id in (SELECT class_lesson_id FROM " . $prefix . "_class_lessons WHERE class_id = '" . $class_id_to_delete . "'));";
                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                if ($result) {
                    // 5. Usuwanie wszystkiego z tabeli class_lesson
                    $query = "DELETE FROM " . $prefix . "_class_lessons WHERE class_lesson_id in (SELECT class_lesson_id FROM (SELECT * FROM " . $prefix . "_class_lessons) as sc WHERE sc.class_id = '" . $class_id_to_delete . "');";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                    if ($result) {
                        // 6. Usunięcie klasy z _classes
                        $query = "DELETE FROM " . $prefix . "_classes WHERE class_id = '" . $class_id_to_delete . "';";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                        $_SESSION['classes_message'] = '<div class="alert alert-success mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Klasa została pomyślnie usunięta!</strong> 
                        </div>';

                    } else {
                        $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Podczas usuwania klasy wystąpił problem, spróbuj ponownie!</strong> 
                        </div>';
                    }
                } else {
                    $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Podczas usuwania klasy wystąpił problem, spróbuj ponownie!</strong> 
                    </div>';
                }
            } else {
                $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Podczas usuwania klasy wystąpił problem, spróbuj ponownie!</strong> 
                        </div>';
            }
        } else {
            $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Podczas usuwania klasy wystąpił problem, spróbuj ponownie!</strong> 
                        </div>';
        }
    } else {
        $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Podczas usuwania klasy wystąpił problem, spróbuj ponownie!</strong> 
                        </div>';
    }

    header("location:../classesManagement.php");
}
