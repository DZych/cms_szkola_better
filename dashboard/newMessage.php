<?php
include("includes/header.php");
include("includes/navbar.php");
require("../config.php");
?>

<script src="https://cdn.tiny.cloud/1/fjioqyviac2n94ft78eu1cmtczs2nlnz7a4xztxgkd81zh6e/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#mytextarea'
    });
</script>

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
                    <form action="messages/sendNewMessage.php" method="POST">

                        <!-- Odbiorca Wiadomości -->
                        <label for="text" class="col-form-label">Odbiorca wiadomości</label>
                        <select id="Selector_Class" class="form-control mb-2" name="receiver">
                            <option value="none" <?php if (!isset($_SESSION['receiver'])) {
                                                        echo ' selected ';
                                                    }  ?> disabled hidden>Wybierz odbiorcę</option>
                            <!-- Załaduj wszystkich dostępnych użytkowników -->
                            <?php
                            $query = "SELECT * FROM " . $prefix . "_users;";
                            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                            while ($wynik = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $wynik['user_id'] . '"';
                                if (isset($_SESSION['receiver'])) {
                                    if ($_SESSION['receiver'] == $wynik['user_id']) {
                                        echo ' selected ';
                                        unset($_SESSION['receiver']);
                                    }
                                }
                                echo '>' . $wynik['first_name'] . ' ' . $wynik['last_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <!-- Temat wiadomości -->
                        <label for="text" class="col-form-label">Temat</label>
                        <input type="text" class="form-control" name="subject" lang="pl" value="<?php echo isset($_SESSION['subject']) ? $_SESSION['subject'] : ''; ?>">
                        <!-- Treść wiadomości -->
                        <label for="text" class="col-form-label">Treść wiadomości</label>
                        <textarea id="mytextarea" name="content" class="form-control mb-2" lang="pl" style="height: 400px;"><?php echo isset($_SESSION['content']) ? $_SESSION['content'] : ''; ?></textarea>
                        <!-- Przycisk wysłania wiadomości -->
                        <input class="btn btn-primary text-center mt-3" type="submit" name="submit" value="Wyślij wiadomość" />

                    </form>
                    <!-- Wyświetlanie błędu -->
                    <?php if (isset($_SESSION['message_error'])) {
                        echo $_SESSION['message_error'];
                        unset($_SESSION['message_error']);
                    }

                    // Czyszczenie danych w sesji
                    if (isset($_SESSION['subject'])) {
                        $_SESSION['subject'] = "";
                    }
                    if (isset($_SESSION['content'])) {
                        $_SESSION['content'] = "";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>