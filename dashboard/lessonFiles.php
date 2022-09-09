<?php
include("includes/header.php");
include("includes/navbar.php");
require ('../config.php');
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php
        include('includes/topbar/topbar.php');
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <?php
        if(isset($_POST['class_lesson_id'])){
            $class_lesson_id = $_POST['class_lesson_id'];
            $_SESSION['class_lesson_id'] = $class_lesson_id;
        }
        else{
            $class_lesson_id = $_SESSION['class_lesson_id'];
        }

        $header_was_set = false;
        if($_SESSION['is_teacher']){

            $query = "SELECT _subjects.name, _classes.name as 'class_name' FROM _class_lessons, _teacher_subject, _teachers, _subjects, _users, _classes
            WHERE _class_lessons.teacher_subject_id = _teacher_subject.teacher_subject_id
            and _teacher_subject.teacher_id = _teachers.teacher_id
            and _teachers.user_id = _users.user_id
            and _teacher_subject.subject_id = _subjects.subject_id
            and _classes.class_id = _class_lessons.class_id
            and _class_lessons.class_lesson_id = '".$class_lesson_id."';";
            $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

            foreach ($result as $plik) {
                echo '
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">'.$plik['name'].' - Klasa '.$plik['class_name'].'</h1>
                ';
            }
            echo '</div>';
            $header_was_set = true;
        }

        if($_SESSION['is_student'] || $_SESSION['is_admin']){

            if($header_was_set == false){
                $query = "SELECT _users.first_name, _users.last_name, _subjects.name FROM _class_lessons, _teacher_subject, _teachers, _subjects, _users
                WHERE _class_lessons.teacher_subject_id = _teacher_subject.teacher_subject_id
                and _teacher_subject.teacher_id = _teachers.teacher_id
                and _teachers.user_id = _users.user_id
                and _teacher_subject.subject_id = _subjects.subject_id
                and _class_lessons.class_lesson_id = '".$class_lesson_id."';";
                $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
                foreach ($result as $plik) {
                    echo '
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">'.$plik['name'].' - '.$plik['first_name'].' '.$plik['last_name'].'</h1>
                    ';
                }
                echo '</div>';
            }          
        }
        ?>


            <!-- Page Heading -->

            <?php
                include('files/tableFiles.php');
            ?>

        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Page Wrapper -->


    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
