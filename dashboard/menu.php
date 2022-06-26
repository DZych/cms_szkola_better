<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="../assets/img/logo.png" style="width: 40px;"/>
        </div>
        <div class="sidebar-brand-text mx-1">ZSP 13</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Zajęcia -->
    <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Zajęcia</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                    <?php
                        if($_SESSION['is_admin'] == true){
                            echo "<a class='collapse-item' href='buttons.html'>Zarządzaj Planem Lekcji</a>";
                        }
                        if($_SESSION['is_teacher'] == true){
                            echo "<a class='collapse-item' href='buttons.html'>Moje lekcje</a>";
                        }
                        if($_SESSION['is_student'] == true){
                            echo "<a class='collapse-item' href='buttons.html'>Plan lekcji</a>";
                        }
                    ?>
                       
                        
                    </div>
                </div>
            </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-edit"></i>
            <span>Oceny</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-comment"></i>
            <span>Wiadomości</span>
        </a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Ustawienia</span></a>
    </li>

     <!-- Nav Item - Charts -->
     <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Użytkownicy</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>