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
                <h1 class="h3 mb-0 text-gray-800">Klasy</h1>
                <a class="btn btn-primary" href="AddEditClass.php?new-class">+ Dodaj nową klase</a>
            </div>



            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th >Nazwa Klasy</th>
                                    <th >Liczba uczniów</th>
                                    <th width="20%">Dostępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM " . $prefix . "_classes;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                foreach ($result as $class) {

                                    $liczba_uczniow = 0;
                                    $query2 = "SELECT COUNT(student_id) as liczba_uczniow FROM _student_class WHERE class_id='".$class['class_id']."';";
                                    $result2 = mysqli_query($link, $query2) or die("Zapytanie zakończone niepowodzeniem");
                                    foreach ($result2 as $count){
                                        $liczba_uczniow = $count['liczba_uczniow'];
                                    }

                                    echo '
                                        <tr>
                                            <td>Klasa ' . $class['name'] .'</td>
                                            <td>' . $liczba_uczniow .'</td>
                                            <td>
                                                <form action="AddEditClass.php?edit-class" method="POST" style="float:left">
                                                <input name="edit_class_id" type="hidden" value="' . $class['class_id'] . '">
                                                <input name="changeStatusSubmit" class="btn btn-info btn-sm ml-2" type="submit" value="Edytuj nazwę">
                                                </form>

                                                <form action="AddEditClass.php?edit-students-class" method="POST" style="float:left">
                                                <input name="edit_students_class_id" type="hidden" value="' . $class['class_id'] . '">
                                                <input name="edit_students_class_name" type="hidden" value="' . $class['name'] . '">
                                                <input name="editStudentClass" class="btn btn-warning text-dark btn-sm ml-2" type="submit" value="Edytuj skład">
                                                </form>
                                    
                                                <form action="classes\deleteClass.php" method="POST" style="float:left" onSubmit="return confirm(\'Czy na pewno chcesz usunąć tą klase?\rUsunięce klasy, spowoduje usunięcie wszystkich informacji powiązanych z nią np. pliki i plan lekcji!\rBądź bardzo ostrożny!!!\')">
                                                <input name="delete_class_id" type="hidden" value="' . $class['class_id'] . '">
                                                <input name="deleteUserSubmit" class="btn btn-danger btn-sm ml-2" type="submit" value="Usuń">
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
            <?php if(isset($_SESSION['classes_message'])) echo $_SESSION['classes_message']; unset($_SESSION['classes_message']);?>
        </div>
    </div>
    <?php

    include('includes/scripts.php');
    include('includes/footer.php');

    ?>