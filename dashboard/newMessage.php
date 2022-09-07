<?php
include("includes/header.php");
include("includes/navbar.php");
require("../config.php")
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
                <h1 class="h3 mb-0 text-gray-800">Nowa wiadomość</h1>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Formularz wysyłania nowej wiadomości -->
                    <form action="" method="post">

                        <!-- Odbiorca Wiadomości -->
                        <label for="text" class="col-form-label">Odbiorca wiadomości</label>
                        <select id="Selector_Class" class="form-control mb-2" name="receiver">
                            <option value="none" selected disabled hidden>Wybierz odbiorcę</option>
                            <?php
                            $query = "SELECT * FROM _users;";
                            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                            while ($wynik = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $wynik['user_id'] . '">' . $wynik['first_name'] . ' ' . $wynik['last_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <!-- Treść wiadomości -->
                        <label for="text" class="col-form-label">Treść wiadomości</label>
                        <textarea name="messageText" class="form-control mb-2" style="height: 200px;">
                        </textarea>
                        <!-- Przycisk wysłania wiadomości -->
                        <input class="btn btn-primary text-center" type="submit" name="showTableBtn" value="Wyślij wiadomość" />
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>