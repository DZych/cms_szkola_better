<?php
include("includes/header.php");
include("includes/navbar.php");
require("../config.php");
?>

<style>
    table tr td a {
        color: #858796;
    }

    table tr td a:hover {
        color: #858796;
        text-decoration: none;
    }

    table.row-clickable tbody tr .custom_td {
        padding: 0;
    }

    table.row-clickable tbody tr .custom_td .clickable {
        display: block;
        padding: 15px;
    }
</style>
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
                        <table class="table table-hover row-clickable" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 15%">Nadawca</th>
                                    <th style="width: 65%">Temat</th>
                                    <th>Data</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM " . $prefix . "_messages where receiver_id = " . $_SESSION['user_id'] . " and deleted_by_receiver=0 ORDER BY date desc;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                foreach ($result as $odebrana_wiadomosc) {
                                    $query2 = "SELECT * FROM _users where user_id = " . $odebrana_wiadomosc['sender_id'] . ";";
                                    $result2 = mysqli_query($link, $query2) or die("Zapytanie zakończone niepowodzeniem");

                                    while ($sender = mysqli_fetch_assoc($result2)) {
                                        echo '
                                        <tr>
                                            <td class="custom_td"><a class="clickable" href="detailsMessage.php?type=inbox&id='.$odebrana_wiadomosc['message_id'].'">' . $sender['first_name'] . ' ' . $sender['last_name'] . '</a></td>
                                            <td class="custom_td"><a class="clickable" href="detailsMessage.php?type=inbox&id='.$odebrana_wiadomosc['message_id'].'">' . $odebrana_wiadomosc["subject"] . '</a></td>
                                            <td class="custom_td"><a class="clickable" href="detailsMessage.php?type=inbox&id='.$odebrana_wiadomosc['message_id'].'">' . $odebrana_wiadomosc["date"] . '</a></td>
                                            <td>
                                                <div id="' . $odebrana_wiadomosc['message_id'] . '" onClick="sendID(this.id)">
                                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#removeMessage">
                                                         <i class="fa fa-trash fa-sm fa-fw"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        ';
                                    }
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
            document.cookie = "message_id=" + message_id + ";SameSite=Lax;";
        }
    </script>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>