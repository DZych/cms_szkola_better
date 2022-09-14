<?php
include("includes/header.php");
include("includes/navbar.php");
require("../config.php");
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <?php
        include('includes/topbar/topbar.php');
        ?>

        <!-- Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Użytkownicy</h1>
                <a class="btn btn-primary" href="changeUserInfo.php?new-user">+ Dodaj nowego użytkownika</a>
            </div>



            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Imię i nazwisko</th>
                                    <th>Email</th>
                                    <th>Data urodzenia</th>
                                    <th>Nr. telefonu</th>
                                    <th>Data utworzenia konta</th>
                                    <th>Status</th>
                                    <th>Rodzaj konta</th>
                                    <th>Dostępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM " . $prefix . "_users;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                foreach ($result as $user) {

                                    $typ_uzytkownika = "";

                                    $query = "SELECT * FROM " . $prefix . "_students WHERE user_id =" . $user['user_id'] . ";";
                                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                    if (mysqli_num_rows($result) == 1) {
                                        $typ_uzytkownika = "Uczeń";
                                    }
                                    $query = "SELECT * FROM " . $prefix . "_teachers WHERE user_id =" . $user['user_id'] . ";";
                                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                    if (mysqli_num_rows($result) == 1) {
                                        $typ_uzytkownika = "Nauczyciel";
                                    }
                                    $query = "SELECT * FROM " . $prefix . "_admins WHERE user_id =" . $user['user_id'] . ";";
                                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                                    if (mysqli_num_rows($result) == 1) {
                                        $typ_uzytkownika = "Administrator";
                                    }

                                    if ($user['active'] == 0) {
                                        $_status = "Wyłączone";
                                    } else {
                                        $_status = "Aktywne";
                                    }

                                    echo '
                                        <tr>
                                            <td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>
                                            <td>' . $user['email'] . '</td>
                                            <td>' . $user['birth_date'] . '</td>
                                            <td>' . $user['phone'] . '</td>
                                            <td>' . $user['date_of_join'] . '</td>
                                            <td><div class="badge ';
                                    if ($user['active'] == 1) {
                                        echo 'bg-success text-white';
                                    } else {
                                        echo 'bg-danger text-white';
                                    }
                                    echo ' text-wrap">' . $_status . '</div></td>
                                             <td>' . $typ_uzytkownika . '</td>

                                            <td>

                                            <form action="changeUserInfo.php" method="POST" style="float:left">
                                            <input name="edit_user_id" type="hidden" value="' . $user['user_id'] . '">
                                            <input name="changeStatusSubmit" class="btn btn-info btn-sm ml-2" type="submit" value="Edytuj">
                                            </form>

                                            </form>
                                                ';
                                    if ($user['active'] == 0) {
                                        echo '
                                        <form action="userManagment/changeStatus.php" method="POST" style="float:left">
                                        <input name="user_id" type="hidden" value="' . $user['user_id'] . '">
                                        <input name="changeStatusSubmit" class="btn btn-warning text-dark btn-sm ml-2" type="submit" value="Aktywuj">
                                        </form>
                                        ';
                                    } else {
                                        echo '
                                        <form action="userManagment/changeStatus.php" method="POST" style="float:left">
                                        <input name="user_id" type="hidden" value="' . $user['user_id'] . '">
                                        <input name="changeStatusSubmit" class="btn btn-warning text-dark btn-sm ml-2" type="submit" value="Dezaktywuj">
                                        </form>
                                        ';
                                    }

                                    echo '
                                            </td>
                                        </tr>
                                        ';
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <?php if(isset($_SESSION['delete_message'])) echo $_SESSION['delete_message']; unset($_SESSION['delete_message']);?>
        </div>
    </div>
    <?php

    include('includes/scripts.php');
    include('includes/footer.php');


    // <form action="userManagment\deleteAccount.php" method="POST" style="float:left" onSubmit="return confirm(\'Czy na pewno chcesz usunąć tego użytkownika?\')">
    // <input name="delete_user_id" type="hidden" value="' . $user['user_id'] . '">
    // <input name="deleteUserSubmit" class="btn btn-danger btn-sm ml-2" type="submit" value="Usuń">

    ?>