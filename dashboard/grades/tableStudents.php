<div class="card shadow mb-4">
    <div class="card-body">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <label>Wybierz klasę</label>
            <select required id="Selector_Class" class="form-control mb-2" style="width:200px;" name="selected_class" onchange="SelectedClass()">
                <option value="" selected disabled hidden>Wybierz klasę</option>
                <?php
                if ($_SESSION['is_teacher'] == true) {
                    $classes_list;
                    $query = "SELECT * FROM _classes;";
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
                    $query = "SELECT * FROM _subjects;";
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
        if (isset($_POST['showTableBtn'])) {
            if (isset($_POST["selected_class"]) & isset($_POST["selected_subject"])) {

                $_SESSION['last_selected_class_id'] = $_POST["selected_class"];
                $class_id = $_POST["selected_class"];
                $_SESSION['last_selected_subject_id'] = $_POST["selected_subject"];
                $subject_id = $_POST["selected_subject"];

        ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Klasa</th>
                                <th>Dodaj ocenę</th>
                                <th>Wyświetl oceny</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = "SELECT _students.student_id, _users.first_name, _users.last_name, _classes.name 
                        FROM _users 
                        INNER JOIN _students ON _users.user_id = _students.user_id 
                        INNER JOIN _student_class ON _student_class.student_id = _students.student_id 
                        INNER JOIN _classes ON _student_class.class_id = _classes.class_id 
                        LEFT JOIN _grades ON _students.student_id = _grades.id_student
                        WHERE _classes.class_id = " . $class_id . " AND _grades.subject_id = " . $subject_id . "";
                            $result = mysqli_query($link, $query);
                            $queryGrades = "";


                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $student) {
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
                                        <td></td>

                                    </tr>

                            <?php
                                }
                            } else {
                                echo "<h5> Brak danych </h5>";
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
        <?php
            } else {
                echo "<h5> Wybierz klasę i przedmiot. </h5>";
            }
        }
        ?>
    </div>
</div>

<!-- Dodaj ocenę Modal-->

<div class="modal fade" id="addGrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">Dodaj ocenę uczniowi: <?= $studentName =  $_COOKIE["name"]; ?></h5>
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
                            <option value="sprawdzian">Sprawdzian</option>
                            <option value="kartkówka">Kartkówka</option>
                            <option value="ustna">Odpowiedź ustna</option>
                            <option value="pracadomowa">Praca domowa</option>
                            <option value="pracanalekcji">Praca na lekcji</option>
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
</script>