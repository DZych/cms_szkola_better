<?php
session_start();
include("../../config.php");

    echo $_POST['subject_id_to_add'];
    echo $_POST['selected_teacher_id'];

    if($_POST['selected_teacher_id'] != null){
        $_SESSION['subject_id_to_add'] = $_POST['subject_id_to_add'];

        $query = "INSERT INTO ".$prefix."._teacher_subject (teacher_id, subject_id) VALUES ('".$_POST['selected_teacher_id']."', '".$_POST['subject_id_to_add']."');";
        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
        if($result == true){
            header("location:../AddEditSubject.php?edit-students-class");
            $_SESSION['teacher_subject_message'] = '<div class="alert alert-success mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Nauczyciel został pomyślnie dodany!</strong> 
            </div>';
        }
        else{
            header("location:../AddEditSubject.php?edit-students-class");
            $_SESSION['teacher_subject_message'] = '<div class="alert alert-danger mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Nauczyciel nie został dodany. Spróbuj ponownie!</strong> 
            </div>';
        }
    }
else{
    header("location:../AddEditSubject.php?edit-students-class");
            $_SESSION['teacher_subject_message'] = '<div class="alert alert-danger mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Żaden nauczyciel nie został wybrany. Spróbuj ponownie!</strong> 
            </div>';
}
?>