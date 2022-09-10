<!-- <div class="topbar-divider d-none d-sm-block"></div> -->
<!-- Nav Item - User Information -->
<?php

require_once("../config.php");

$query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_SESSION['user_id'] . "";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) == 1) {
    $wiersz = mysqli_fetch_assoc($result);

    if (!empty($wiersz['avatar'])) {
        echo '
            <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">' . $wiersz['first_name'] . " " . $wiersz['last_name'] . '</span>
                <img class="img-profile rounded-circle" src="data:image/jpeg;base64,' . base64_encode($wiersz['avatar']) . '" alt="">
            </a>';
    } else {
        echo '
            <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">' . $wiersz['first_name'] . " " . $wiersz['last_name'] . '</span>
                <img class="img-profile rounded-circle" src="img/user.png" alt="">
            </a>';
    }
}
?>
<!-- Dropdown - User Information -->
<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
    <!-- <a class="dropdown-item" href="#">
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
        Profile
    </a> -->
    <a class="dropdown-item" href="changeUserInfo.php">
        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
        Settings
    </a>
    <!-- <a class="dropdown-item" href="#">
        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
        Activity Log
    </a> -->
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
    </a>
</div>
</li>