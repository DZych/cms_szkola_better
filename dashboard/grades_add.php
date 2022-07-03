<?php
include("includes/header.php");
include("includes/navbar.php");
require '../config.php';
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

            <!-- Page Heading -->
            <?php
            if (isset($_POST['add_grade_btn'])) {
                $student_id = $_POST['student_id'];

                $query = "SELECT _students.student_id, _users.first_name, _users.last_name, _classes.name FROM _users INNER JOIN _students ON _users.user_id = _students.user_id INNER JOIN _student_class ON _student_class.student_id = _students.student_id INNER JOIN _classes ON _student_class.class_id = _classes.class_id WHERE _students.student_id = '$student_id'";
                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $student) {
            ?>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dodaj ocenę uczniowi: <?= $student['first_name'] ?> <?= $student['last_name'] ?> z klasy <?= $student['name'] ?></h1>
                        </div>

                    <?php
                    }
                } else {
                    ?>
                    <h4>Coś poszło nie tak.</h4><?php }
                                        }
                                        echo $_SESSION['user_id'];
                                                ?>

            <div class="row">
                <div class="card-body">


                    <form action="scripts/php/addGrade.php" method="POST">
                        <div class="mb-3">
                            <label>Przedmiot</label>
                            <select class="form-control" name="subject">
                                <option value="1">Matematyka</option>
                                <option value="2">Historia</option>
                            </select>
                        </div>
                        <div class="mb3">
                            <label>Rodzaj oceny</label>
                            <select class="form-control" name="type">
                                <option value="sprawdzian">Sprawdzian</option>
                                <option value="kartkówka">Kartkówka</option>
                                <option value="ustna">Odpowiedź ustna</option>
                                <option value="pracadomowa">Praca domowa</option>
                                <option value="pracanalekcji">Praca na lekcji</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-2">
                            <label>Ocena</label>
                            <input type="number" name="grade" class="form-control" min="1" max="6" step="0.5" />
                        </div>
                        <input type="hidden" name="student_id" value='<?= $student_id ?>'>
                        <button type="button" class="btn btn-secondary">Wyjdź</button>
                        <button type="submit" name="saveGrade_btn" class="btn btn-primary">Dodaj ocenę</button>
                    </form>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->



    </div>
    <!-- End of Page Wrapper -->

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>