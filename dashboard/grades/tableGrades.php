<?php
$userid = $_SESSION['user_id'];
$query = "SELECT `student_id` FROM `_students` WHERE `user_id`= $userid";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
while ($wynik = mysqli_fetch_assoc($result)) {
    $studentId = $wynik['student_id'];
}
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Przedmiot</th>
                        <th>Oceny</th>
                    </tr>
                </thead>
                <tbody>
                    <?php {
                        $query = "SELECT _grades.subject_id, _subjects.name FROM _grades INNER JOIN _subjects ON _grades.subject_id=_subjects.subject_id WHERE _grades.id_student = $studentId group by _grades.subject_id;";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                        while ($wynik = mysqli_fetch_assoc($result)) {

                    ?>
                            <tr>
                                <td><?= $wynik['name'] ?></td>
                                <td><?php
                                    $id = $studentId;
                                    $subID = $wynik['subject_id'];
                                    $grades_list;
                                    $queryGrades = "SELECT `id`, `grade` FROM `_grades` WHERE `id_student` = $id AND `subject_id` = $subID;";
                                    $resultGrades = mysqli_query($link, $queryGrades) or die("Zapytanie zakończone niepowodzeniem");
                                    while ($wynikGrades = mysqli_fetch_assoc($resultGrades)) {
                                    ?>
                                        <div id=<?= $wynikGrades['id'] ?> onClick="" class="float-left ml-1">
                                            <a name="show_grade_btn" class="<?php
                                                                            if ($wynikGrades['grade'] < 2) {
                                                                            ?>btn btn-danger<?php
                                                                                        } else {
                                                                                            ?>btn btn-success<?php
                                                                                                                        }
                                                                                                                            ?>" href="#" data-toggle="modal" data-target="#showGrade"><?= $wynikGrades['grade'] ?></a>
                                        </div>
                                    <?php

                                        $grades_list[$wynikGrades['id']] = $wynikGrades['grade'];
                                    }

                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>


                </tbody>
            </table>
        </div>
    </div>
</div>