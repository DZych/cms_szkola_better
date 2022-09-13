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
            if ($_SESSION['is_student']) {
            ?>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Oceny</h1>
                </div>
            <?php
                include('grades/tableGrades.php');
            } elseif ($_SESSION['is_teacher']) {
            ?>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Oceny uczniów</h1>
                </div>


            <?php
                include('grades/tableStudents.php');
            }


            ?>

        </div>
        <!-- End of Main Content -->



    </div>
    <!-- End of Page Wrapper -->

    <?php
    include('includes/scripts.php');
    ?>