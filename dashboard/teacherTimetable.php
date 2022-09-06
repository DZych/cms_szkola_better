<?php
    session_start();
    if(!isset($_SESSION['zalogowany'])){
        header("location:../login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include_once("includes/navbar.php") ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include_once("topbar.php") ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php
                        if(isset($_GET['forFiles'])){
                            echo '<h1 class="h3 mb-4 text-gray-800">Wybierz lekcje aby zobaczyć pliki dla niej</h1>';
                        }
                        else{
                            echo '<h1 class="h3 mb-4 text-gray-800">Plan Lekcji</h1>';
                        }
                    ?>

                    <?php
                    if($_SESSION['is_teacher'] == true){

                        require_once("../config.php");

                        $query = "SELECT MAX(lesson_number) as lessons_in_week FROM _timetable, _teacher_subject, _teachers, _users, _classes, _subjects, _class_lessons
                                WHERE _timetable.class_lesson_id = _class_lessons.class_lesson_id
                                and _class_lessons.class_id = _classes.class_id
                                and _teacher_subject.teacher_subject_id = _class_lessons.teacher_subject_id
                                and _teacher_subject.teacher_id = _teachers.teacher_id
                                and _teachers.user_id = _users.user_id
                                and _teacher_subject.subject_id = _subjects.subject_id 
                                and _users.user_id = ".$_SESSION['user_id'].";";
                        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                        while ($wynik = mysqli_fetch_assoc($result)) {
                            $max_lessons_in_week = $wynik['lessons_in_week'];
                        }


                        $query = "SELECT _class_lessons.class_lesson_id, _timetable.day, _timetable.lesson_number, _classes.name as class_name,  _classes.class_id, _users.first_name, _users.last_name, _subjects.name as subject_name, _users.user_id 
                                    FROM _timetable, _classes, _teacher_subject, _teachers, _subjects, _users, _class_lessons 
                                    WHERE _timetable.class_lesson_id  = _class_lessons.class_lesson_id 
                                    and _class_lessons.class_id = _classes.class_id
                                    and _teacher_subject.teacher_subject_id = _class_lessons.teacher_subject_id 
                                    and _teacher_subject.teacher_id = _teachers.teacher_id
                                    and _teachers.user_id = _users.user_id
                                    and _teacher_subject.subject_id = _subjects.subject_id 
                                    and _users.user_id = ".$_SESSION['user_id']."
                                    ORDER BY _timetable.lesson_number";
                        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                        $lessons = array();
                        $days = array();
                        $subjects = array();
                        $classes = array();
                        $number_of_lessons = 0;
                        $lessons_array = array();
                        $class_lesson_ids = array();
                        while ($wynik = mysqli_fetch_assoc($result)) {
                                $lessons[$number_of_lessons] = $wynik['lesson_number'];
                                $days[$number_of_lessons] = $wynik['day'];
                                $subjects[$number_of_lessons] = $wynik['subject_name'];
                                $first_names[$number_of_lessons] = $wynik['first_name'];
                                $last_names[$number_of_lessons] = $wynik['last_name'];
                                $classes[$number_of_lessons] = $wynik['class_name'];
                                $class_lesson_ids[$number_of_lessons] = $wynik['class_lesson_id'];
                                //$lessons_array[$number_of_lessons] = array($wynik['lesson_number'],$wynik['day'],$wynik['subject_name']);
                                $number_of_lessons++;
                        }


                        $array_of_hours = array("8:15- 9:00", "9:10- 9:55", "10:05-10:50", "11:00-11:45", "11:55-12:40", "13:00-13:45", "14:05-14:50", "14:55-15:40", "15:45-16:30");

                        echo '
                        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">'.$_SESSION['first_name'].' '.$_SESSION['last_name'].'</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-primary text-dark">
                                            <th width="2%">Nr</th>
                                            <th width="8%">Godz</th>
                                            <th width="18%">Poniedziałek</th>
                                            <th width="18%">Wtorek</th>
                                            <th width="18%">Środa</th>
                                            <th width="18%">Czwartek</th>
                                            <th width="18%">Piątek</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                    // i - numer lekcji
                                    // j - dzien tygodnia

                                    for ($i=1; $i<$max_lessons_in_week+1; $i++) {
                                        echo '
                                        <tr >
                                            <td class="table-primary text-dark"><strong>'.($i).'</strong></td>
                                            <td class="table-primary text-dark">'.($array_of_hours[$i]).'</td>';
                                            $added_lessons = 0;
                                            for($j=1; $j<6; $j++){
                                                $last_used_j = null;
                                                $last_used_i = null;

                                                for($k=0; $k<$number_of_lessons; $k++){
                                                    if($j == $days[$k] && $i == $lessons[$k]){
                                                        echo '<td>
                                                            <form action="lessonFiles.php" method="post">
                                                                <button type="submit" name="class_lesson_id" value="'. $class_lesson_ids[$k].'" class="btn btn-link text-left">
                                                                    <strong>'.$subjects[$k].'</strong></br>Klasa '.$classes[$k].'
                                                                </button>
                                                            </form>
                                                        </td>';
                                                        $added_lessons++;
                                                        $last_used_j = $j;
                                                        $last_used_i = $i;
                                                    }
                                                }

                                                // if($i == 3 && $j == 5){
                                                //     break;
                                                // }
                                                    if($i > $last_used_i ){
                                                        echo '<td></td>';
                                                    }
                                                    else if($j > $last_used_j ){
                                                            echo '<td></td>';     
                                                    }   
                                            }
                                        }
                                           
                                       echo '</tr>
                                        ';
                                        }
                                       
                                   echo '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        ';
                                    
                    ?>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../scripts/php/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>