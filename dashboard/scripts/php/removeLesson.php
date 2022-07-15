<?php
$timetable_id = $_COOKIE["timetable_id"];

$query = "DELETE FROM _timetable
WHERE timetable_id = ".$timetable_id.";";

$result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

?>