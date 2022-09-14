<?php
session_start();
include("../../config.php");

if(isset($_POST['Add_subject'])){
    $query = "INSERT INTO ".$prefix."_subjects (name) VALUES ('".$_POST['subjectName']."');";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    if($result){
        $_SESSION['subject_message'] = '<div class="alert alert-success mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Przedmiot został pomyślnie dodany!</strong> 
        </div>';
        header("location:../subjectsManagement.php");
    }
    else{
        $_SESSION['subject_message'] = '<div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Przedmiotu nie udało się dodać! Spróbuj ponownie.</strong> 
        </div>';
        header("location:../subjectsManagement.php");
    }
}
if(isset($_POST['Edit_subject'])){
    $query = "UPDATE ".$prefix."_subjects SET name='".$_POST['subjectName']."' WHERE subject_id=".$_SESSION['edit_subject_id']."";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    if($result){
        $_SESSION['subject_message'] = '<div class="alert alert-success mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Przedmiot został pomyślnie zaktulizowany!</strong> 
        </div>';
        header("location:../subjectsManagement.php");
    }
    else{
        $_SESSION['subject_message'] = '<div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Przedmiotu nie udało się zaktualizować! Spróbuj ponownie.</strong> 
        </div>';
        header("location:../subjectsManagement.php");
    }
}
?>