<?php
include("includes/header.php");
include("includes/navbar.php");
require("../config.php");
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <?php
        include('includes/topbar/topbar.php');
        ?>

        <!-- Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Przedmioty</h1>
                <a class="btn btn-primary" href="AddEditSubject.php?new-class">+ Dodaj nowy przedmiot</a>
            </div>



            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th >Nazwa przedmioty</th>
                                    <th >Liczba nauczycieli</th>
                                    <th width="20%">Dostępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM " . $prefix . "_subjects;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                foreach ($result as $subject) {

                                    $liczba_nauczycieli = 0;
                                    $query2 = "SELECT COUNT(teacher_id) as liczba_nauczycieli FROM ".$prefix."_teacher_subject WHERE subject_id='". $subject['subject_id']."';";
                                    $result2 = mysqli_query($link, $query2) or die("Zapytanie zakończone niepowodzeniem");
                                    foreach ($result2 as $count){
                                        $liczba_nauczycieli = $count['liczba_nauczycieli'];
                                    }

                                    echo '
                                        <tr>
                                            <td>' .  $subject['name'] .'</td>
                                            <td>' . $liczba_nauczycieli .'</td>
                                            <td>
                                                <form action="AddEditSubject.php?edit-class" method="POST" style="float:left">
                                                <input name="edit_subject_id" type="hidden" value="' .  $subject['subject_id'] . '">
                                                <input name="changeStatusSubmit" class="btn btn-info btn-sm ml-2" type="submit" value="Edytuj nazwę">
                                                </form>

                                                <form action="AddEditSubject.php?edit-subject-teacher" method="POST" style="float:left">
                                                <input name="edit-subject-teacher_id" type="hidden" value="' .  $subject['subject_id'] . '">
                                                <input name="edit-subject-teacher_name" type="hidden" value="' .  $subject['name'] . '">
                                                <input name="editSubjectTeacher" class="btn btn-warning text-dark btn-sm ml-2" type="submit" value="Edytuj skład">
                                                </form>
                                            </td>
                                        </tr>
                                        ';
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <?php if(isset($_SESSION['subject_message'])) echo $_SESSION['subject_message']; unset($_SESSION['subject_message']);?>
        </div>
    </div>
    <?php

    include('includes/scripts.php');
    include('includes/footer.php');

    ?>