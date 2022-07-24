<?php
    // get values from GET
    $file_id= $_GET['file_id'];
    $class_lesson_files_id= $_GET['class_lesson_files_id'];
    $filename= $_GET['filename'];
    // get database settings
    include('../../config.php');

    // delete from _class_lesson_files table
    $query = "DELETE FROM `_class_lessons_files` WHERE class_lesson_files_id = '".$class_lesson_files_id."';";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    // delete from _files table
    if($result == true){
        $query = "DELETE FROM `_files` WHERE file_id = '".$file_id."';";
        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    }

    //delete from folder
    if($result == true){
        unlink("../../uploads/zajecia/".$filename);
    }

    header("location:../lessonFiles.php");
?>