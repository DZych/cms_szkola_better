<div class="card shadow mb-4">
    <div class="card-body">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <label>Wybierz klasę</label>
            <select required id="Selector_Class" class="form-control mb-2" style="width:200px;" name="selected_class" onchange="SelectedClass()">
                <option value="" selected disabled hidden>Wybierz klasę</option>
                <?php
                if ($_SESSION['is_teacher'] == true) {
                    $classes_list;
                    $query = "SELECT * FROM " . $prefix . "_classes;";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    while ($wynik = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $wynik['class_id'] . '">Klasa ' . $wynik['name'] . '</option>';
                        $classes_list[$wynik['class_id']] = $wynik['name'];
                    }
                }
                ?>
            </select>
            <label>Wybierz przedmiot</label>
            <select required id="Selector_Subject" class="form-control mb-2" style="width:200px;" name="selected_subject" onchange="SelectedSubject()">
                <option value="" selected disabled hidden>Wybierz przedmiot</option>
                <?php
                if ($_SESSION['is_teacher'] == true) {
                    $subjects_list;
                    $query = "SELECT * FROM " . $prefix . "_subjects;";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    while ($wynik = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $wynik['subject_id'] . '">' . $wynik['name'] . '</option>';
                        $subjects_list[$wynik['subject_id']] = $wynik['name'];
                    }
                }
                ?>
            </select>
            <input class="btn btn-primary text-center mt-1 mb-3" type="submit" name="showTableBtn" value="Wyświetl oceny uczniów" />
        </form>

        <?php
        if (isset($_POST['AddGrade'])) {
            include("scripts/php/addGrade.php");
        }
        if (isset($_POST['RemoveGrade'])) {
            include("scripts/php/removeGrade.php");
        }
        if (isset($_POST['showTableBtn'])) {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <?php
                    if (isset($_POST["selected_class"]) & isset($_POST["selected_subject"])) {

                        $_SESSION['last_selected_class_id'] = $_POST["selected_class"];
                        $class_id = $_POST["selected_class"];
                        $_SESSION['last_selected_subject_id'] = $_POST["selected_subject"];
                        $subject_id = $_POST["selected_subject"];

                        $query = "SELECT " . $prefix . "_students.student_id, " . $prefix . "_users.first_name, " . $prefix . "_users.last_name, " . $prefix . "_classes.name, COUNT(" . $prefix . "_grades.id_student) as ilosc 
                        FROM " . $prefix . "_users 
                        INNER JOIN " . $prefix . "_students ON " . $prefix . "_users.user_id = " . $prefix . "_students.user_id 
                        INNER JOIN " . $prefix . "_student_class ON " . $prefix . "_student_class.student_id = " . $prefix . "_students.student_id 
                        INNER JOIN " . $prefix . "_classes ON " . $prefix . "_student_class.class_id = " . $prefix . "_classes.class_id 
                        LEFT JOIN " . $prefix . "_grades ON " . $prefix . "_students.student_id = " . $prefix . "_grades.id_student
                        WHERE _classes.class_id = " . $class_id . " GROUP BY " . $prefix . "_students.student_id";
                        $result = mysqli_query($link, $query);


                        if (mysqli_num_rows($result) > 0) {
                    ?><thead>
                                <tr>
                                    <th>Imię</th>
                                    <th>Nazwisko</th>
                                    <th>Klasa</th>
                                    <th>Dodaj ocenę</th>
                                    <th>Oceny</th>
                                    <th>Zarządaj ocenami</th>

                                </tr>
                            </thead>
                            <tbody><?php
                                    foreach ($result as $student) {
                                        if (isset($student['student_id'])) {
                                    ?>




                                        <tr>
                                            <td><?= $student['first_name'] ?></td>
                                            <td><?= $student['last_name'] ?></td>
                                            <td><?= $student['name'] ?></td>
                                            <td>
                                                <div id=<?= $student['student_id'] ?> title='<?= $student['first_name'] ?> <?= $student['last_name'] ?>' onClick="SendStudentID(this.id, this.title)">
                                                    <a name="add_grade_btn" class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#addGrade">Dodaj</a>
                                                </div>
                                            </td>
                                            <td><?php
                                                $id = $student['student_id'];
                                                $subID = $_COOKIE["subject_id"];
                                                $grades_list = null;
                                                $gradesInfo_list = null;
                                                $query = "SELECT `id`, `grade` FROM " . $prefix . "`_grades` WHERE `id_student` = $id AND `subject_id` = $subID;";
                                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");




                                                while ($wynik = mysqli_fetch_assoc($result)) {
                                                    $idGrade = $wynik['id'];
                                                    $queryGradeInfo = "SELECT " . $prefix . "_grades_type.type, " . $prefix . "_users.first_name, " . $prefix . "_users.last_name
                                                    FROM " . $prefix . "_grades 
                                                    INNER JOIN " . $prefix . "_grades_type ON " . $prefix . "_grades.type = " . $prefix . "_grades_type.type_id 
                                                    INNER JOIN " . $prefix . "_teachers ON " . $prefix . "_grades.teacher_id = " . $prefix . "_teachers.teacher_id
                                                    INNER JOIN " . $prefix . "_users ON " . $prefix . "_teachers.user_id = " . $prefix . "_users.user_id
                                                    WHERE " . $prefix . "_grades.id = $idGrade";
                                                    $resultGradeInfo = mysqli_query($link, $queryGradeInfo) or die("Zapytanie zakończone niepowodzeniem");

                                                    while ($wynikGradeInfo = mysqli_fetch_assoc($resultGradeInfo)) {
                                                ?>
                                                        <div id=<?= $wynik['id'] ?> data-placement="top" title="<?= $wynikGradeInfo['type'] . " (" . $wynikGradeInfo['first_name'] . " " . $wynikGradeInfo['last_name'] . ")" ?>" class="tt float-left ml-1">
                                                            <a name="grade" class="<?php
                                                                                    if ($wynik['grade'] < 2) {
                                                                                    ?>btn btn-danger<?php
                                                                                                } else {
                                                                                                    ?>btn btn-success<?php
                                                                                                                    }
                                                                                                                        ?>" href="#" data-toggle="modal" data-target="#showGrade"><?= $wynik['grade'] ?></a>
                                                        </div>
                                                <?php

                                                        $gradesInfo_list[$wynik['id']] = $wynikGradeInfo['type'] . " (" . $wynikGradeInfo['first_name'] . " " . $wynikGradeInfo['last_name'] . ")";
                                                    }
                                                    $grades_list[$wynik['id']] = $wynik['grade'];
                                                }

                                                ?>
                                            </td>
                                            <td style="width:250px;">
                                                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                                    <select required id="Selector_Grade" class="form-control mb-2" style="width:250px;" name="selected_grade" onchange="SelectedGradeEdit()">
                                                        <option value="" selected disabled hidden>Wybierz ocenę do usunięcia</option>
                                                        <?php
                                                        if ($_SESSION['is_teacher'] == true) {
                                                            foreach ($gradesInfo_list as $key => $info) {
                                                                echo '<option value="' . $key . '">' . $grades_list[$key] . " " . $info . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input class="btn btn-danger text-center mt-1 mb-3 float-left ml-1" type="submit" name="RemoveGrade" value="Usuń" />
                                                </form>
                                            </td>

                                        </tr>



                    <?php
                                        } else {
                                            echo "<h5> Brak danych </h5>";
                                        }
                                    }
                                } else {
                                    echo "<h5> Brak danych </h5>";
                                }
                            } else {
                                echo "<h5> Wybierz klasę i przedmiot. </h5>";
                            }
                            echo "<h5> Oceny uczniów klasy " . $classes_list[$_POST["selected_class"]] . " z przedmiotu: " . $subjects_list[$_POST["selected_subject"]] . "</h5>";
                        }

                    ?>

            </div>
    </div>
</div>


<!-- Dodaj ocenę Modal-->

<div class="modal fade" id="addGrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">Dodaj ocenę uczniowi: </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

                    <div class="mb3">
                        <label>Rodzaj oceny</label>
                        <select required id="TypeGrade" class="form-control" name="type" onchange="SelectedTypeGrade()">
                            <option value="" selected disabled hidden>Wybierz rodzaj oceny</option>
                            <?php
                            if ($_SESSION['is_teacher'] == true) {
                                $query = "SELECT * FROM " . $prefix . "_grades_type;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                while ($wynik = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $wynik['type_id'] . '">' . $wynik['type'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 mt-2">
                        <label>Ocena</label>
                        <input required id="Grade" type="number" name="grade" class="form-control" min="1" max="6" step="0.5" onchange="SelectedGrade()" />
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Anuluj</button>

                <input type="submit" class="btn btn-primary" value="Dodaj" name="AddGrade" />

            </div>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    function SelectedClass() {
        var x = document.getElementById("Selector_Class").value;
        document.cookie = "class_id=" + x + ";SameSite=Lax;";
    }

    function SelectedSubject() {
        var x = document.getElementById("Selector_Subject").value;
        document.cookie = "subject_id=" + x + ";SameSite=Lax;";
    }

    function SendStudentID(id, name) {
        document.cookie = "student_id=" + id + ";SameSite=Lax;";
        document.cookie = "name=" + name + ";SameSite=Lax;";
    }

    function SelectedTypeGrade() {
        var x = document.getElementById("TypeGrade").value;
        document.cookie = "type_grade=" + x + ";SameSite=Lax;";
    }

    function SelectedGrade() {
        var x = document.getElementById("Grade").value;
        document.cookie = "grade=" + x + ";SameSite=Lax;";
    }

    function SelectedGradeEdit() {
        var x = document.getElementById("Selector_Grade").value;
        document.cookie = "gradeSelected=" + x + ";SameSite=Lax;";
    }
</script>