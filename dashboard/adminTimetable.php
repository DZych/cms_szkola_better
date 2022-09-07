<?php
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header("location:../login.php");
    require_once("../config.php");
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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


                    <?php
                    if ($_SESSION['is_admin'] == true) {
                        require_once("../config.php");
                        $query = "SELECT * FROM _classes;";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                        while ($wynik = mysqli_fetch_assoc($result)) {
                            $class_name = $wynik['name'];
                            $class_id = $wynik['class_id'];
                        }
                    }
                    ?>

                    <!-- Page Heading -->

                    <?php
                    if (isset($_GET['forFiles'])) {
                        echo '<h1 class="h3 mb-4 text-gray-800">Wybierz klasę aby zobaczyć pliki dla niej</h1>';
                    } else {
                        echo '<h1 class="h3 mb-4 text-gray-800">Zarządzaj planem lekcji</h1>';
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <p class="h4">Wybierz klasę</p>
                            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                                <select id="Selector_Class" class="form-control mb-2" style="width:200px;" name="selected_class" onchange="SelectedClass()">
                                    <option value="none" selected disabled hidden>Wybierz klasę</option>
                                    <?php
                                    if ($_SESSION['is_admin'] == true) {
                                        $classes_list;
                                        $query = "SELECT * FROM _classes;";
                                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                        while ($wynik = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $wynik['class_id'] . '">Klasa ' . $wynik['name'] . '</option>';
                                            $classes_list[$wynik['class_id']] = $wynik['name'];
                                        }
                                    } else {
                                        $classes_list;
                                    }

                                    ?>
                                </select>
                                <input class="btn btn-primary text-center" type="submit" name="showTableBtn" value="Wyświetl plan" />
                            </form>

                            <?php
                            if ($_SESSION['is_admin'] == true) {

                                if (isset($_POST['AddLesson'])) {
                                    include("scripts/php/addLesson.php");
                                }
                                if (isset($_POST['RemoveLesson'])) {
                                    include("scripts/php/removeLesson.php");
                                }

                                if (isset($_POST['showTableBtn']) || isset($_POST['AddLesson']) || isset($_POST['RemoveLesson'])) {

                                    if (isset($_POST['showTableBtn'])) {
                                        $_SESSION['last_selected_class_id'] = $_POST["selected_class"];
                                        $class_id = $_POST["selected_class"];
                                    }
                                    if (isset($_POST['AddLesson']) || isset($_POST['RemoveLesson'])) {
                                        $class_id = $_SESSION['last_selected_class_id'];
                                    }


                                    $query = "SELECT _timetable.timetable_id, _timetable.day, _timetable.lesson_number, _classes.name as class_name,  _classes.class_id, _users.first_name, _users.last_name, _subjects.name as subject_name 
                                                                FROM _timetable, _classes, _teacher_subject, _teachers, _subjects, _users, _class_lessons
                                                                WHERE _timetable.class_lesson_id = _class_lessons.class_lesson_id
                                                                and _class_lessons.class_id = _classes.class_id
                                                                and _class_lessons.teacher_subject_id = _teacher_subject.teacher_subject_id
                                                                and _teacher_subject.teacher_id = _teachers.teacher_id
                                                                and _teacher_subject.subject_id = _subjects.subject_id
                                                                and _teachers.user_id = _users.user_id
                                                                and _classes.class_id = " . $class_id . "
                                                                ORDER BY _timetable.lesson_number";
                                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                    $lessons = array();
                                    $days = array();
                                    $subjects = array();
                                    $timetable_id = array();
                                    $number_of_lessons = 0;
                                    $lessons_array = array();
                                    while ($wynik = mysqli_fetch_assoc($result)) {
                                        $lessons[$number_of_lessons] = $wynik['lesson_number'];
                                        $days[$number_of_lessons] = $wynik['day'];
                                        $timetable_id[$number_of_lessons] = $wynik['timetable_id'];
                                        $subjects[$number_of_lessons] = $wynik['subject_name'];
                                        $first_names[$number_of_lessons] = $wynik['first_name'];
                                        $last_names[$number_of_lessons] = $wynik['last_name'];
                                        //$lessons_array[$number_of_lessons] = array($wynik['lesson_number'],$wynik['day'],$wynik['subject_name']);
                                        $number_of_lessons++;
                                    }
                                    $array_of_hours = array("8:15- 9:00", "9:10- 9:55", "10:05-10:50", "11:00-11:45", "11:55-12:40", "13:00-13:45", "14:05-14:50", "14:55-15:40", "15:45-16:30");


                                    echo '
                                                <p class="h5 text-center mt-5"><strong> Klasa ' . $classes_list[$_SESSION['last_selected_class_id']] . '</strong><p>
                                                <div class="table-responsive mt-3">
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

                                    for ($i = 1; $i < 9; $i++) {
                                        echo '
                                                            <tr >
                                                                <td class="table-primary text-dark"><strong>' . ($i) . '</strong></td>
                                                                <td class="table-primary text-dark">' . ($array_of_hours[$i - 1]) . '</td>';
                                        $added_lessons = 0;
                                        for ($j = 1; $j < 6; $j++) {
                                            $last_used_j = null;
                                            $last_used_i = null;
                                            for ($k = 0; $k < $number_of_lessons; $k++) {

                                                if ($j == $days[$k] && $i == $lessons[$k]) {
                                                    echo '<td>
                                                                            <div id="' . $timetable_id[$k] . '" onClick="sendTimetableID(this.id)">
                                                                            <strong>' . $subjects[$k] . '</strong> 
                                                                            <a class="btn float-right" href="#" data-toggle="modal" data-target="#removeLesson">
                                                                                <i class="fa fa-trash fa-sm fa-fw mr-2 "></i>
                                                                            </a>
                                                                            </br>
                                                                            ' . $first_names[$k] . ' ' . $last_names[$k] . '
                                                                            </div>
                                                                            </td>';
                                                    $added_lessons++;
                                                    $last_used_j = $j;
                                                    $last_used_i = $i;
                                                }
                                            }
                                            if ($i > $last_used_i) {
                                                echo '<td style="height: 73px;">
                                                                            <div id="' . $i . "_" . $j . '" onClick="sendIDs(this.id)">
                                                                            <a class="btn btn-block text-center align-items-center" href="#" data-toggle="modal" data-target="#addLesson">
                                                                            <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400 text-center"></i>
                                                                        </a>
                                                                        </div>
                                                                            </td>';
                                            } else if ($j > $last_used_j) {
                                                echo '<td style="height: 73px;">
                                                                            <div id="' . $i . "_" . $j . '" onClick="sendIDs(this.id)">
                                                                            <a class="btn btn-block text-center align-items-center" name="input_' . $i . '_' . $j . '" href="#" data-toggle="modal" data-target="#addLesson">
                                                                            <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                                                            </a>
                                                                            </div>
                                                                            </td>';
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
                                            ';
                            }
                            ?>
                        </div>

                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->

                    <?php
                    include('includes/footer.php');
                    ?>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->
        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    <!-- Add lesson Modal-->
    <div class="modal fade" id="addLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">Dodaj lekcje</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td style="height: 73px;">
                                <p class="pr-1 pl-3 pt-1">Wybierz przedmiot</p>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <select id="Selector" class="form-control mb-2" name="selected_subject" onchange="onSelectChange()">
                                        <option value="none" selected disabled hidden>Proszę wybrać przedmiot</option>
                                        <?php
                                        if ($_SESSION['is_admin'] == true) {
                                            $classes_list;
                                            $query = "SELECT _teacher_subject.teacher_subject_id, _teacher_subject.subject_id, _teacher_subject.teacher_id, _subjects.name, _users.first_name, _users.last_name, _users.user_id  
                                        FROM _teacher_subject, _users, _subjects, _teachers
                                        WHERE  _teacher_subject.subject_id = _subjects.subject_id
                                        and _teacher_subject.teacher_id = _teachers.teacher_id
                                        and _teachers.user_id = _users.user_id order by name";
                                            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                            while ($wynik = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $wynik['teacher_subject_id'] . '">' . $wynik['name'] . ' - ' . $wynik['first_name'] . ' ' . $wynik['last_name'] . '</option>';
                                                $classes_list[$wynik['class_id']] = $wynik['name'];
                                            }
                                        }

                                        ?>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Anuluj</button>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="submit" class="btn btn-primary" value="Dodaj" name="AddLesson" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove lesson Modal-->
    <div class="modal fade" id="removeLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">Usuń lekcje</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Czy na pewno chcesz usunąć tą lekcje?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Anuluj</button>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="submit" class="btn btn-primary" value="Usuń" name="RemoveLesson" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function sendIDs(id) {
            var full_id = id;
            var i = full_id.slice(0, 1);
            var j = full_id.slice(2, 3);
            document.cookie = "numer_lekcji2=" + i + ";SameSite=Lax;";
            document.cookie = "dzien_tygodnia=" + j + ";SameSite=Lax;";
        }

        function onSelectChange() {
            var x = document.getElementById("Selector").value;
            document.cookie = "teacher_subject_id=" + x + ";SameSite=Lax;";
        }

        function SelectedClass() {
            var x = document.getElementById("Selector_Class").value;
            document.cookie = "class_id=" + x + ";SameSite=Lax;";
        }

        function sendTimetableID(id) {
            document.cookie = "timetable_id=" + id + ";SameSite=Lax;";
        }
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>