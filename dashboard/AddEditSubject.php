<?php
include("includes/header.php");
include("includes/navbar.php");
?>

<script src="https://cdn.tiny.cloud/1/fjioqyviac2n94ft78eu1cmtczs2nlnz7a4xztxgkd81zh6e/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#mytextarea'
    });
</script>

<form method="POST" action="newsEdit.php">
</form>

<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <script type="text/javascript">
            src = "js/password.js"
        </script>
        <?php
        include('includes/topbar/topbar.php');
        $chekpaswd = false
        ?>

        <!-- Account page navigation-->

        <?php

        require_once("../config.php");

        if (isset($_GET['new-class'])) {
            echo '
                <div class="container-xl px-4 mt-4">
                <div>
                    <div class="row mt-2 mb-2">
                    <div class="col-xl-12">
                    <!-- Account details card-->
                    <div class="card">
                        <div class="card-header">Nowy przedmiot</div>
                            <div class="card-body">
                                <form method="POST" action="subjects/AddEditSubjectScripts.php">

                                    <label class="col-form-label" for="inputTitle">Nazwa przedmiotu</label><br>
                                    <input class="form-control" id="inputTitle" name="subjectName" type="text" placeholder="Nazwa przedmiotu" required />
                                
                                    <!-- Save changes button-->
                                    <input class="btn btn-primary mt-2" type="submit" name="Add_subject" value="Dodaj przedmiot">
                                </form>                               
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }


        if (isset($_GET['edit-class'])) {

            $edit_subject_id = $_POST['edit_subject_id'];
            $_SESSION['edit_subject_id'] = $edit_subject_id;

            $query = "SELECT * FROM " . $prefix . "_subjects where subject_id=$edit_subject_id;";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

            while ($wynik = mysqli_fetch_assoc($result)) {
                $subject_name = $wynik['name'];
            }
            echo '
                <div class="container-xl px-4 mt-4">
                    <div>
                        <div class="row mt-2 mb-2">
                        <div class="col-xl-12">
                        <!-- Account details card-->
                        <div class="card">
                            <div class="card-header">Edycja przedmiotu</div>
                                <div class="card-body">
                                    <form method="POST" action="subjects/AddEditSubjectScripts.php">

                                        <label class="col-form-label" for="inputTitle">Nazwa przedmiotu</label><br>
                                        <input class="form-control" id="inputTitle" name="subjectName" type="text" placeholder="Nazwa przedmiotu" required value="' .  $subject_name . '"/>
                                        
                                        <!-- Save changes button-->
                                        <input class="btn btn-primary mt-2" type="submit" name="Edit_subject" value="Edytuj klase">
                                    </form>                            
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        if (isset($_GET['edit-students-class'])) {

            if(isset($_POST['edit_students_class_id'])){
                $class_id = $_POST['edit_students_class_id'];
                $class_name = $_POST['edit_students_class_name'];
                $_SESSION['class_name_to_add'] = $_POST['edit_students_class_name'];
                $_SESSION['class_id_edited'] = $class_id;
            }
            else{
                $class_id = $_SESSION['class_id_edited'];
                $class_name = $_SESSION['class_name_to_add'];
            }


            echo '        
                <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Klasa ' . $class_name . '</h1>
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addStudentToClass">+ Dodaj nowego studenta</a>
            </div>



            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Imię i nazwisko</th>
                                    <th>Email</th>
                                    <th>Data urodzenia</th>
                                    <th>Dostępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>';

            $query = "SELECT * FROM " . $prefix . "_student_class as sc, " . $prefix . "_students as s, " . $prefix . "_users as u WHERE sc.student_id = s.student_id and s.user_id = u.user_id and class_id=" . $class_id . ";";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

            foreach ($result as $wynik) {
                echo '
                                        <tr>
                                            <td>' . $wynik['first_name'] . ' ' . $wynik['last_name'] . '</td>
                                            <td>' . $wynik['email'] . '</td>
                                            <td>' . $wynik['birth_date'] . '</td>
                                            <td>
                                    
                                                <form action="classes/deleteClassStudent.php" method="POST" style="float:left" onSubmit="return confirm(\'Czy na pewno chcesz usunąć tego ucznia z tej klasy?\')">
                                                <input name="student_class_id_delete" type="hidden" value="' . $wynik['student_class_id'] . '">
                                                <input name="class_id_delete" type="hidden" value="' . $wynik['student_class_id'] . '">
                                                <input name="deleteUserSubmit" class="btn btn-danger btn-sm ml-2" type="submit" value="Usuń">
                                                </form>


                                            </td>
                                        </tr>
                                        ';
            }
            echo '
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>';
            if (isset($_SESSION['class_student_message'])) echo $_SESSION['class_student_message'];
            unset($_SESSION['class_student_message']);
            echo '
            </div>
            </div>';
        }
        if (isset($_GET['edit-subject-teacher'])) {

            if(isset($_POST['edit-subject-teacher_id'])){
                $subject_id = $_POST['edit-subject-teacher_id'];
                $subject_name = $_POST['edit-subject-teacher_name'];
                $_SESSION['subject_name_to_add'] = $subject_name;
                $_SESSION['subject_id_edited'] = $subject_id;
            }
            else{
                $subject_id = $_SESSION['subject_id_edited'];
                $subject_name = $_SESSION['subject_name_to_add'];
            }


            echo '        
                <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Nauczyciele dla przedmiotu ' . $subject_name . '</h1>
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addTeacherToSubject">+ Dodaj nowego nauczyciela</a>
            </div>



            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Imię i nazwisko</th>
                                    <th>Email</th>
                                    <th>Data urodzenia</th>
                                    <th>Dostępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>';

            $query = "SELECT * FROM " . $prefix . "_teacher_subject as ts, " . $prefix . "_teachers as t, " . $prefix . "_users as u WHERE ts.teacher_id = t.teacher_id and t.user_id = u.user_id and subject_id=" . $subject_id . ";";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

            foreach ($result as $wynik) {
                echo '
                                        <tr>
                                            <td>' . $wynik['first_name'] . ' ' . $wynik['last_name'] . '</td>
                                            <td>' . $wynik['email'] . '</td>
                                            <td>' . $wynik['birth_date'] . '</td>
                                            <td>
                                    
                                                <form action="subjects/deleteTeacherSubject.php" method="POST" style="float:left" onSubmit="return confirm(\'Czy na pewno chcesz usunąć tego nauczyciela z prowadzenia tego przedmiotu?\')">
                                                <input name="teacher_subject_id_delete" type="hidden" value="' . $wynik['teacher_subject_id'] . '">
                                                <input name="deleteUserSubmit" class="btn btn-danger btn-sm ml-2" type="submit" value="Usuń">
                                                </form>


                                            </td>
                                        </tr>
                                        ';
            }
            echo '
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>';
            if (isset($_SESSION['teacher_subject_message'])) echo $_SESSION['teacher_subject_message'];
            unset($_SESSION['teacher_subject_message']);
            echo '
            </div>
            </div>';
        }
        ?>

        <!-- Add student Modal-->
        <div class="modal fade" id="addTeacherToSubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">Dodaj nauczyciela dla przedmiotu <?php echo $subject_name ?></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td >
                                    <p>Wybierz Nauczyciele</p>
                                </td>
                                <td>
                                    <form action="subjects/AddTeacherToClass.php" method="POST">
                                        <input type="hidden" name="subject_id_to_add" value="<?php echo $_SESSION['subject_id_edited']; ?>" />
                                        <select id="Selector" class="form-control mb-2" name="selected_teacher_id" onchange="onSelectChange()" required>
                                            <option value="none" selected disabled hidden>Proszę wybrać nauczyciela</option>
                                            <?php

                                            $query = "SELECT * from ".$prefix."_teachers as t, ".$prefix."_users as u WHERE t.user_id = u.user_id and t.teacher_id NOT IN(SELECT t.teacher_id FROM ".$prefix."_teacher_subject as ts, ".$prefix."_teachers as t, _users as u WHERE ts.teacher_id = t.teacher_id and t.user_id = u.user_id and subject_id='". $_SESSION['subject_id_edited']."');";
                                            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                            while ($wynik = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $wynik['teacher_id'] . '">' . $wynik['first_name'] . ' ' . $wynik['last_name'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>  
                                        <input type="submit" class="btn btn-primary" value="Dodaj" name="AddStudentToClass" />
                                    </form>
                                    </td>
                                        </tr>
                        </table>
                    </div>

                    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
                    <?php
                    include('includes/scripts.php');
                    include('includes/footer.php');

                    ?>