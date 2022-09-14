<?php
session_start();
include("../../config.php");
    if($_POST['selected_student_id'] != null){
        $_SESSION['class_id_to_add'] = $_POST['class_id_to_add'];

        $query = "INSERT INTO ".$prefix."._student_class (student_id, class_id) VALUES ('".$_POST['selected_student_id']."', '".$_POST['class_id_to_add']."');";
        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
        if($result == true){
            header("location:../AddEditClass.php?edit-students-class");
            $_SESSION['class_student_message'] = '<div class="alert alert-success mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Uczeń został pomyślnie dodany!</strong> 
            </div>';
        }
        else{
            header("location:../AddEditClass.php?edit-students-class");
            $_SESSION['class_student_message'] = '<div class="alert alert-danger mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Uczeń nie został dodany. Spróbuj ponownie!</strong> 
            </div>';
        }
    }
else{
    header("location:../AddEditClass.php?edit-students-class");
            $_SESSION['class_student_message'] = '<div class="alert alert-danger mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Żaden uczeń nie został wybrany. Spróbuj ponownie!</strong> 
            </div>';
}
?>