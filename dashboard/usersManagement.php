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
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0" >
                            <thead class="thead-light">
                                <tr>
                                    <th>Imię i nazwisko</th>
                                    <th>Email</th>
                                    <th>Data urodzenia</th>
                                    <th>Nr. telefonu</th>
                                    <th>Status</th>
                                    <th>Data utworzenia konta</th>
                                    <th>Dstępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM " . $prefix . "_users;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                foreach ($result as $user) {

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
                                            <td><div class="badge ';
                                    if ($user['active'] == 1) {
                                        echo 'bg-success text-white';
                                    } else {
                                        echo 'bg-danger text-white';
                                    }
                                    echo ' text-wrap">' . $_status . '</div></td>
                                            <td>' . $user['date_of_join'] . '</td>

                                            <td>

                                            <form action="changeUserInfo.php" method="POST" style="float:left">
                                            <input name="edit_user_id" type="hidden" value="' . $user['user_id'] . '">
                                            <input name="changeStatusSubmit" class="btn btn-primary btn-sm ml-2" type="submit" value="Edytuj">
                                            </form>

                                                <div id="' . $user['user_id'] . '" onClick="sendID(this.id)" style="float: left;">
                                                    <a class="btn btn-danger btn-sm ml-2" href="#" data-toggle="modal" data-target="#removeMessage">
                                                         Usuń
                                                    </a>
                                                </div>
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


        </div>
    </div>

    <!-- Remove message -->
    <div class="modal fade" id="removeMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">Usuń Wiadomość</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Czy na pewno chcesz usunąć tą wiadomość?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Anuluj</button>
                    <form action="messages/removeMessageInbox.php" method="post">
                        <input type="submit" class="btn btn-primary" value="Usuń" name="RemoveLesson" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function sendID(id) {
            var message_id = id;
            document.cookie = "user_id=" + message_id + ";SameSite=Lax;";
        }
    </script>
    <?php

    include('includes/scripts.php');
    include('includes/footer.php');

    ?>