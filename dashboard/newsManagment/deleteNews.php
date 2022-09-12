<?php
session_start();
include("../../config.php");

if(isset($_POST['delete_news_id'])){
    $query = "SELECT image FROM ".$prefix."_news WHERE news_id=".$_POST['delete_news_id'].";";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    foreach ($result as $path){
        unlink($path['image']);
    }

    $query2 = "DELETE FROM ".$prefix."._news
    WHERE news_id=".$_POST['delete_news_id'].";";
    $result2 = mysqli_query($link, $query2) or die ("Zapytanie zakończone niepowodzeniem");

    if($result2 == true){
        $_SESSION['news_message'] = '<div class="alert alert-success mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Artykuł został usunięty!</strong>
        </div>';
    }
    else{
        $_SESSION['news_message'] = '<div class="alert alert-danger mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Artykuł nie został usunięty!</strong>
        </div>';
    }
    header("location:../newsManagement.php");
}

?>