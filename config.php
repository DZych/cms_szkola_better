<?php

/* Ustawienie zmiennych połączeniowych */
$host = "sql11.freesqldatabase.com";
$db_user = "sql11501306";
$db_password = "U54TTaM1n2";
$db_name = "sql11501306";


 /* Łączenie i wybranie bazy */
 $link = mysqli_connect($host, $db_user, $db_password) or die ("Nie można się połączyć");
 mysqli_select_db ($link, $db_name) or die ("Nie mozna wybrać bazy danych");
 mysqli_query($link, "SET NAMES UTF8");

?>