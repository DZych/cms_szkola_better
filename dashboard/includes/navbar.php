<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../assets/img/logo.png" style="width: 40px;" />
        </div>
        <div class="sidebar-brand-text mx-1">ZSP 13</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Zajęcia -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Plan Lekcji</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <?php
                if ($_SESSION['is_admin'] == true) {
                    echo "<a class='collapse-item' href='adminTimetable.php'>Zarządzaj Planem Lekcji</a>";
                }
                if ($_SESSION['is_teacher'] == true) {
                    echo "<a class='collapse-item' href='teacherTimetable.php'>Moje lekcje</a>";
                }
                if ($_SESSION['is_student'] == true) {
                    echo "<a class='collapse-item' href='studentTimetable.php'>Plan lekcji</a>";
                }
                ?>


            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="grades.php" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-edit"></i>
            <span>Oceny</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">

        <?php
        // if ($_SESSION['is_admin'] == true) {
        //     echo "<a class='nav-link collapsed' href='teacherTimetable.php?forFiles=1' aria-expanded='true' aria-controls='collapseTwo'>";

        // }
        // if ($_SESSION['is_teacher'] == true) {
        //     echo "<a class='nav-link collapsed' href='adminTimetable.php?forFiles=1' aria-expanded='true' aria-controls='collapseTwo'>";
        // }
        // if ($_SESSION['is_student'] == true) {
        //     echo "<a class='nav-link collapsed' href='studentTimetable.php?forFiles=1' aria-expanded='true' aria-controls='collapseTwo'>";
        // }
        ?>
            <i class="fas fa-fw fa-file"></i>
            <span>Pliki dla zajęć</span>
        </a>
    </li> -->

    <!-- Nav Item - Wiadomości -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-comment"></i>
            <span>Wiadomości</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class='collapse-item' href='newMessage.php'>Nowa wiadomość</a>
                <a class='collapse-item' href='inboxMessage.php'>Odebrane</a>
                <a class='collapse-item' href='sentMessage.php'>Wysłane</a>
            </div>
        </div>
    </li>

    <?php
    if ($_SESSION['is_admin'] == true) {
        echo '
        <!-- Nav Item - News -->
        <li class="nav-item">
            <a class="nav-link" href="newsManagement.php">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>News</span></a>
        </li>
        ';
    }
    ?>

<?php
    if ($_SESSION['is_admin'] == true) {
        echo '
        <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link" href="classesManagement.php">
                <i class="fas fa-fw fa-school"></i>
                <span>Klasy</span></a>
        </li>
        ';
    }
    ?>

    <?php
    if ($_SESSION['is_admin'] == true) {
        echo '
        <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link" href="usersManagement.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Użytkownicy</span></a>
        </li>
        ';
    }
    ?>
    

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="changeUserInfo.php">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Ustawienia</span></a>
    </li>




    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>


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

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>