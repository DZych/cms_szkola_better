<?php
include("includes/header.php");
include("includes/navbar.php");
?>

<script src="https://cdn.tiny.cloud/1/fjioqyviac2n94ft78eu1cmtczs2nlnz7a4xztxgkd81zh6e/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#mytextarea'
    });
</script>

<form method="POST" action="newsEdit.php">
</form>

<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <script type="text/javascript">
            src = "js/password.js"
        </script>
        <?php
        include('includes/topbar/topbar.php');
        $chekpaswd = false
        ?>

        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->

            <?php

            require_once("../config.php");

            if (isset($_GET['new-news'])) {
                echo '
                <div>
                    <div class="row mt-2 mb-2">
                    <div class="col-xl-12">
                    <!-- Account details card-->
                    <div class="card">
                        <div class="card-header">Nowy news</div>
                            <div class="card-body">
                                <form method="POST" action="newsManagment/editAddNews.php" enctype="multipart/form-data">

                                    <label class="col-form-label" for="inputTitle">Zdjęcie</label><br>
                                    <input type="file" name="file" /><br>

                                    <label class="col-form-label" for="inputTitle">Tytuł</label>
                                    <input class="form-control" id="inputTitle" name="title" type="text" placeholder="Wprowadź tytuł" required />


                                    <label for="text" class="col-form-label">Treść</label>
                                    <textarea id="mytextarea" name="content" placeholder="Wprowadź treść" class="form-control mb-2" lang="pl" style="height: 400px;"></textarea>

                                    
                                    <!-- Save changes button-->
                                    <input class="btn btn-primary mt-2" type="submit" name="Add_news" value="Dodaj news">
                                </form>                               
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }


            if (isset($_GET['edit-news'])) {
                $edit_news_id = $_POST['editAdd_news_id'];
                $_SESSION['edit_news_id'] = $edit_news_id;

                $query = "SELECT * FROM " . $prefix . "_news where news_id = $edit_news_id";
                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                while ($wynik = mysqli_fetch_assoc($result)) {
                    $post_title = $wynik['title'];
                    $post_contet = $wynik['content'];
                    $post_image = $wynik['image'];
                    $post_date = $wynik['date'];

                    $prefixPath = '../';
                    $image_path = $post_image;

                    if (substr($image_path, 0, strlen($prefixPath)) == $prefixPath) {
                        $image_path = substr($image_path, strlen($prefixPath));
                    }
                }
                echo '
                    <div>
                        <div class="row mt-2 mb-2">
                        <div class="col-xl-12">
                        <!-- Account details card-->
                        <div class="card">
                            <div class="card-header">Edycja newsa</div>
                                <div class="card-body">
                                    <form method="POST" action="newsManagment/editAddNews.php" enctype="multipart/form-data">

                                        <label class="col-form-label" for="inputTitle">Zdjęcie</label><br>
                                        <img class="img-fluid rounded text-center" src="' . $image_path . '" alt="..." /><br> 
                                        <input type="file" name="file" class="mt-2"/><br>

                                        <label class="col-form-label" for="inputTitle">Tytuł</label>
                                        <input class="form-control" id="inputTitle" name="title" type="text" placeholder="Wprowadź tytuł" value="' . $post_title . '" required />

                                        <label for="text" class="col-form-label">Treść</label>
                                        <textarea id="mytextarea" name="content" placeholder="Wprowadź treść" class="form-control mb-2" lang="pl" style="height: 400px;">' . $post_contet . '</textarea>

                                        
                                        <!-- Save changes button-->
                                        <input class="btn btn-primary mt-2" type="submit" name="edit_news" value="Edytuj news">
                                    </form>                            
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
            <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
            <?php
            include('includes/scripts.php');
            include('includes/footer.php');

            ?>