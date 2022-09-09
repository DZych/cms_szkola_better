<?php
include("includes/header.php");
include("includes/navbar.php");
require("../config.php");
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
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Szczegóły wiadomości</h1>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <?php
                    if ($_GET['type'] == "sent") {
                        $query = "SELECT * FROM " . $prefix . "_messages where message_id = " . $_GET['id'] . ";";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                        while ($wiadomosc = mysqli_fetch_assoc($result)) {

                            $query2 = "SELECT * FROM _users where user_id = " . $wiadomosc['receiver_id'] . ";";
                            $result2 = mysqli_query($link, $query2) or die("Zapytanie zakończone niepowodzeniem");

                            while ($user = mysqli_fetch_assoc($result2)) {
                                echo '
                                <table width="100%">
                                <tr style="font-size:23px">
                                    <td style="width:80px">Temat:</td>
                                    <td style="font-weight:bold">' . $wiadomosc['subject'] . '</td>
                                </tr>
                                <tr>
                                    <td>Odbiorca: </td>
                                    <td style="font-weight:bold">' . $user['first_name'] . ' ' . $user['last_name'] . '</td>
                                    <td width="11%">' . $wiadomosc['date'] . '</td>
                                </tr>
                            </table>
                            <hr>
                            <p>' . $wiadomosc['content'] . '</p>
                            <hr>';
                            }
                        }
                    }
                    if ($_GET['type'] == "inbox") {
                        $query = "SELECT * FROM " . $prefix . "_messages where message_id = " . $_GET['id'] . ";";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                        while ($wiadomosc = mysqli_fetch_assoc($result)) {

                            $query2 = "SELECT * FROM _users where user_id = " . $wiadomosc['sender_id'] . ";";
                            $result2 = mysqli_query($link, $query2) or die("Zapytanie zakończone niepowodzeniem");

                            while ($user = mysqli_fetch_assoc($result2)) {
                                echo '
                                <table width="100%">
                                <tr style="font-size:23px">
                                    <td style="width:80px">Temat:</td>
                                    <td style="font-weight:bold">' . $wiadomosc['subject'] . '</td>
                                </tr>
                                <tr>
                                    <td>Odbiorca: </td>
                                    <td style="font-weight:bold"> ' . $user['first_name'] . ' ' . $user['last_name'] . '</td>
                                    <td width="11%">' . $wiadomosc['date'] . '</td>
                                </tr>
                            </table>
                            <hr>
                            <p>' . $wiadomosc['content'] . '</p>
                            <hr>
                                
                            <form action="messages/reply.php" method="post">
                            <input name="content" value="'.$wiadomosc['content'].'" type="hidden">
                            <input name="subject" value="'.$wiadomosc['subject'].'" type="hidden">
                            <input name="date" value="'.$wiadomosc['date'].'" type="hidden">
                            <input name="sender" value="' . $user['first_name'] . ' ' . $user['last_name'] .'" type="hidden">
                            <input class="btn btn-success" type="submit" name="reply" value="Odpowiedz">
                            </form>
                            ';
                            
                            }
                        }
                    }

                    ?>

                </div>
            </div>

        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Page Wrapper -->

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>