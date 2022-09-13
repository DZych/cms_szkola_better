<?php
session_start();
include("../../config.php");

if(isset($_POST['Add_class'])){
    $query = "INSERT INTO ".$prefix."_classes (name) VALUES ('".$_POST['className']."');";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    if($result){
        $_SESSION['classes_message'] = '<div class="alert alert-success mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Klasa została pomyślnie dodana!</strong> 
        </div>';
        header("location:../classesManagement.php");
    }
    else{
        $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Klasy nie udało się dodać! Spróbuj ponownie.</strong> 
        </div>';
        header("location:../classesManagement.php");
    }
}
if(isset($_POST['Edit_class'])){
    $query = "UPDATE ".$prefix."_classes SET name='".$_POST['className']."' WHERE `class_id`=".$_SESSION['edit_class_id']."";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    if($result){
        $_SESSION['classes_message'] = '<div class="alert alert-success mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Klasa została pomyślnie zaktualizowaana!</strong> 
        </div>';
        header("location:../classesManagement.php");
    }
    else{
        $_SESSION['classes_message'] = '<div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Klasy nie udało się zaktualizować! Spróbuj ponownie.</strong> 
        </div>';
        header("location:../classesManagement.php");
    }
}
?>