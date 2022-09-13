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
                        <div class="card-header">Nowa klasa</div>
                            <div class="card-body">
                                <form method="POST" action="classes/AddEditClassScripts.php">

                                    <label class="col-form-label" for="inputTitle">Nazwa klasy (wpisz samą nazwe w formie liczby rzymskiej np. II)</label><br>
                                    <input class="form-control" id="inputTitle" name="className" type="text" placeholder="Nazwaa klasy" required />
                                
                                    <!-- Save changes button-->
                                    <input class="btn btn-primary mt-2" type="submit" name="Add_class" value="Dodaj klase">
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

            $edit_class_id = $_POST['edit_class_id'];
            $_SESSION['edit_class_id'] = $edit_class_id;

            $query = "SELECT * FROM " . $prefix . "_classes where class_id=$edit_class_id;";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

            while ($wynik = mysqli_fetch_assoc($result)) {
                $class_name = $wynik['name'];
            }
            echo '
                <div class="container-xl px-4 mt-4">
                    <div>
                        <div class="row mt-2 mb-2">
                        <div class="col-xl-12">
                        <!-- Account details card-->
                        <div class="card">
                            <div class="card-header">Edycja Klasy</div>
                                <div class="card-body">
                                    <form method="POST" action="classes/AddEditClassScripts.php">

                                        <label class="col-form-label" for="inputTitle">Nazwa klasy (wpisz samą nazwe w formie liczby rzymskiej np. II)</label><br>
                                        <input class="form-control" id="inputTitle" name="className" type="text" placeholder="Nazwaa klasy" required value="' . $class_name . '"/>
                                        
                                        <!-- Save changes button-->
                                        <input class="btn btn-primary mt-2" type="submit" name="Edit_class" value="Edytuj klase">
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
                $class_id = $_SESSION['class_id_to_add'];
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
        ?>

        <!-- Add student Modal-->
        <div class="modal fade" id="addStudentToClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">Dodaj studenta do klasy <?php echo $class_name ?></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td >
                                    <p>Wybierz Ucznia</p>
                                </td>
                                <td>
                                    <form action="classes/addStudentToClass.php" method="POST">
                                        <input type="hidden" name="class_id_to_add" value="<?php echo $_SESSION['class_id_edited'] ?>" />
                                        <select id="Selector" class="form-control mb-2" name="selected_student_id" onchange="onSelectChange()" required>
                                            <option value="none" selected disabled hidden>Proszę wybrać ucznia</option>
                                            <?php
                                            $classes_list;
                                            $query = "SELECT * FROM " . $prefix . "_students WHERE " . $prefix . "_students.user_id in (SELECT user_id FROM " . $prefix . "_students WHERE student_id NOT IN (SELECT sc.student_id FROM " . $prefix . "_student_class as sc, " . $prefix . "_students as s, " . $prefix . "_users as u WHERE sc.student_id = s.student_id and s.user_id = u.user_id)) ";
                                            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                            while ($wynik = mysqli_fetch_assoc($result)) {

                                                $query2 = "SELECT * FROM " . $prefix . "_users as u, " . $prefix . "_students as s where u.user_id=s.user_id and s.student_id=" . $wynik['student_id'] . ";";
                                                $result2 = mysqli_query($link, $query2) or die("Zapytanie zakończone niepowodzeniem");
                                                while ($wynik2 = mysqli_fetch_assoc($result2)) {
                                                    echo '<option value="' . $wynik['student_id'] . '">' . $wynik2['first_name'] . ' ' . $wynik2['last_name'] . '</option>';
                                                    $classes_list[$wynik['class_id']] = $wynik['name'];
                                                }
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