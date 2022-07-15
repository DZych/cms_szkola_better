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
                    <h1 class="h3 mb-4 text-gray-800">Plan Lekcji</h1>
                    

                    <?php
                    if($_SESSION['is_student'] == true){

                        require_once("../config.php");
                        $query = "SELECT _users.user_id, _classes.name, _classes.class_id 
                                    FROM _student_class, _students, _users, _classes
                                    WHERE _student_class.student_id = _students.student_id
                                    and _students.user_id = _users.user_id
                                    and _student_class.class_id = _classes.class_id
                                    and _users.user_id = ".$_SESSION['user_id'].";";
                        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                        while ($wynik = mysqli_fetch_assoc($result)) {
                            $class_name = $wynik['name'];
                            $class_id = $wynik['class_id'];
                        }

                        $query = "SELECT MAX(lesson_number) as lessons_in_week FROM ".$prefix."_timetable WHERE ".$prefix."class_id = ".$class_id.";";
                        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                        while ($wynik = mysqli_fetch_assoc($result)) {
                            $max_lessons_in_week = $wynik['lessons_in_week'];
                        }


                        $query = "SELECT _timetable.day, _timetable.lesson_number, _classes.name as class_name,  _classes.class_id, _users.first_name, _users.last_name, _subjects.name as subject_name 
                                    FROM _timetable, _classes, _teacher_subject, _teachers, _subjects, _users 
                                    WHERE _timetable.class_id = _classes.class_id 
                                    and _teacher_subject.teacher_subject_id = _timetable.teacher_subject_id 
                                    and _teacher_subject.teacher_id = _teachers.teacher_id
                                    and _teachers.user_id = _users.user_id
                                    and _teacher_subject.subject_id = _subjects.subject_id 
                                    and _classes.class_id = ".$class_id."
                                    ORDER BY _timetable.lesson_number";
                        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                        $lessons = array();
                        $days = array();
                        $subjects = array();
                        $number_of_lessons = 0;
                        $lessons_array = array();
                        while ($wynik = mysqli_fetch_assoc($result)) {
                                $lessons[$number_of_lessons] = $wynik['lesson_number'];
                                $days[$number_of_lessons] = $wynik['day'];
                                $subjects[$number_of_lessons] = $wynik['subject_name'];
                                $first_names[$number_of_lessons] = $wynik['first_name'];
                                $last_names[$number_of_lessons] = $wynik['last_name'];
                                //$lessons_array[$number_of_lessons] = array($wynik['lesson_number'],$wynik['day'],$wynik['subject_name']);
                                $number_of_lessons++;
                        }


                        $array_of_hours = array("8:15- 9:00", "9:10- 9:55", "10:05-10:50", "11:00-11:45", "11:55-12:40", "13:00-13:45", "14:05-14:50", "14:55-15:40", "15:45-16:30");


                        echo '
                        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Klasa '.$class_name.'</h6>
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
                                                
                                                for($k=0; $k<$number_of_lessons; $k++){
                                                    $last_used_j;
                                                    $last_used_i;
                                                    if($j == $days[$k] && $i == $lessons[$k]){
                                                        echo '<td><strong>'.$subjects[$k].'</strong> </br>'.$first_names[$k].' '.$last_names[$k].'</td>';
                                                        $added_lessons++;
                                                        $last_used_j = $j;
                                                        $last_used_i = $i;
                                                    }
                                                    else if($j != $days[$k] && $i != $lessons[$k]){
                                                    }
                                                }

                                                if($i > $last_used_i){
                                                    echo '<td></td>';
                                                }
                                                else if($j > $last_used_j){
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