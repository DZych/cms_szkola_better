<?php
session_start();
include("../../config.php");

if(isset($_POST['teacher_subject_id_delete'])){
    $query = "DELETE FROM ".$prefix."._teacher_subject WHERE teacher_subject_id = '".$_POST['teacher_subject_id_delete']."';";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
    
    if($result == true){
        header("location:../AddEditSubject.php?edit-subject-teacher");
        $_SESSION['teacher_subject_message'] = '<div class="alert alert-success mt-2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Nauczyciel został usunięty z klasy!</strong> 
                </div>';
        
    }
    else{
        header("location:../AddEditSubject.php?edit-subject-teacher");
        $_SESSION['teacher_subject_message'] = '<div class="alert alert-danger mt-2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Nauczyciel nie został usunięty z klasy. Spróbuj ponownie!</strong> 
                </div>';
    }
}
?>