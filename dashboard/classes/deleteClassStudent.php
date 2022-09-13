<?php
session_start();
include("../../config.php");

if(isset($_POST['student_class_id_delete'])){
    $query = "DELETE FROM ".$prefix."._student_class WHERE student_class_id = '".$_POST['student_class_id_delete']."';";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
    
    if($result == true){
        header("location:../AddEditClass.php?edit-students-class");
        $_SESSION['class_student_message'] = '<div class="alert alert-success mt-2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Uczeń został usunięty z klasy!</strong> 
                </div>';
        
    }
    else{
        header("location:../AddEditClass.php?edit-students-class");
        $_SESSION['class_student_message'] = '<div class="alert alert-danger mt-2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Uczeń nie został usunięty z klasy. Spróbuj ponownie!</strong> 
                </div>';
    }
}
?>