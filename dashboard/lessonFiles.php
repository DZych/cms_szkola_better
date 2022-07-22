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
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Pliki</h1>
        </div>
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