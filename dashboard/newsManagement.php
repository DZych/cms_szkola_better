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
                <h1 class="h3 mb-0 text-gray-800">Newsy</h1>
                <a class="btn btn-primary" href="newsEdit.php?new-news">+ Dodaj nowy news</a>
            </div>



            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="70%">Tytuł</th>
                                    <th>Data dodania</th>
                                    <th>Dostępne akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM " . $prefix . "_news ORDER BY date desc ;";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                foreach ($result as $news) {
                                    echo '
                                        <tr>
                                            <td>' . $news['title'] .'</td>
                                            <td>' . $news['date'] . '</td>
                                            <td>
                                                <form action="newsEdit.php?edit-news" method="POST" style="float:left">
                                                <input name="editAdd_news_id" type="hidden" value="' . $news['news_id'] . '">
                                                <input name="changeStatusSubmit" class="btn btn-info btn-sm ml-2" type="submit" value="Edytuj">
                                                </form>
                                    
                                                <form action="newsManagment\deleteNews.php" method="POST" style="float:left" onSubmit="return confirm(\'Czy na pewno chcesz usunąć ten artykuł?\')">
                                                <input name="delete_news_id" type="hidden" value="' . $news['news_id'] . '">
                                                <input name="deleteUserSubmit" class="btn btn-danger btn-sm ml-2" type="submit" value="Usuń">
                                                </form>
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
            <?php if(isset($_SESSION['news_message'])) echo $_SESSION['news_message']; unset($_SESSION['news_message']);?>
        </div>
    </div>
    <?php

    include('includes/scripts.php');
    include('includes/footer.php');

    ?>