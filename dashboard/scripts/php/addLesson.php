<?php
$numer_lekcji2 =  $_COOKIE["numer_lekcji2"];
$dzien_tygodnia = $_COOKIE["dzien_tygodnia"];
$teacher_subject_id = $_COOKIE["teacher_subject_id"];
$class_id = $_COOKIE["class_id"];

// sprawdz czy taka lekcja już istnieje dla danej klasy
$query = "SELECT * FROM ".$prefix."_class_lessons WHERE teacher_subject_id = ".$teacher_subject_id." and class_id=".$class_id.";";
$result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

// jesli istnieje
if(mysqli_num_rows($result) == 1){
    while($wynik = mysqli_fetch_assoc($result)) {
        $class_lesson_id = $wynik['class_lesson_id'];
      }
      // dodaj do planu lekcji
      $query = "INSERT INTO ".$prefix."_timetable (`day`, `lesson_number`, `class_lesson_id`)
      VALUES ('$dzien_tygodnia', '$numer_lekcji2', '$class_lesson_id');";
      $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem"); 
      
      if($result == true){
        $last_id = mysqli_insert_id($link);
      }
      
}
//jesli nie istnieje
else{
    //to najpierw dodaj taka lekcje dla tej klasy
    $query = "INSERT INTO ".$prefix."_class_lessons (`teacher_subject_id`, `class_id`)
    VALUES ('".$teacher_subject_id."','".$class_id."');";
    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");  

    // a potem dodaj tą lekcje do planu lekcji
    if($result == true){
        $last_id = mysqli_insert_id($link);
        $query = "INSERT INTO ".$prefix."_timetable (`day`, `lesson_number`, `class_lesson_id`)
      VALUES ('$dzien_tygodnia', '$numer_lekcji2', '$last_id');";
      $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem"); 
    }
}
?>