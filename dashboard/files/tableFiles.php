<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nazwa pliku</th>
                        <th>Data udostepnienia</th>
                        <th>Akcje</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    if($_SESSION['is_student']){

                        $query = "SELECT * FROM _class_lessons, _class_lessons_files, _files
                        WHERE _class_lessons.class_lesson_id = _class_lessons_files.class_lesson_id
                        and _class_lessons_files.file_id = _files.file_id
                        and _class_lessons_files.class_lesson_id = '".$_POST['class_lesson_id']."';";
                        $result = mysqli_query($link, $query);
    
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $plik) {
                                echo '
                                <tr>
                                    <td>'.$plik["filename"].'</td>
                                    <td>'.$plik["creation_date"].'</td>
                                    <td>
                                    <a class="btn btn-success btn-sm" href="files/download_file.php?name='.$plik["filename"].'">Pobierz</a>        
                                    </td>
                                </tr>
                                ';
                            }
                        } else {
                            echo "<h5><strong> Brak plików </strong></h5>";
                        }
                    }
                    if($_SESSION['is_teacher'] || $_SESSION['is_admin']){

                        $query = "SELECT * FROM _class_lessons, _class_lessons_files, _files
                        WHERE _class_lessons.class_lesson_id = _class_lessons_files.class_lesson_id
                        and _class_lessons_files.file_id = _files.file_id
                        and _class_lessons_files.class_lesson_id = '".$_POST['class_lesson_id']."';";
                        $result = mysqli_query($link, $query);
    
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $plik) {
                                echo '
                                <tr>
                                    <td>'.$plik["filename"].'</td>
                                    <td>'.$plik["creation_date"].'</td>
                                    <td>
                                    <a class="btn btn-success btn-sm" href="files/download_file.php?name='.$plik["filename"].'">Pobierz</a>        
                                    </td>
                                </tr>
                                ';
                            }
                            echo '<tr class="odd">
                            <td colspan="3" class="dataTables_empty" valign="top">
                                <div class="card shadow mb-4 w-25">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Nowy plik</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="upload.php" method="post" enctype="multipart/form-data">
                                            <input type="file" name="file" />
                                            </br>
                                            </br>
                                            <button class="btn btn-primary btn-sm" type="submit" name="upload">Dodaj nowy plik</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                          </tr>';
                        } else {
                            echo "<h3 class='text-center'><strong> Brak plików </strong></h3>";
                            echo '<tr class="odd">
                                    <td colspan="3" class="dataTables_empty" valign="top">
                                        <div class="card shadow mb-4 w-25">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Nowy plik</h6>
                                            </div>
                                            <div class="card-body">
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                                    <input type="file" name="file" />
                                                    </br>
                                                    </br>
                                                    <button class="btn btn-primary btn-sm" type="submit" name="upload">Dodaj nowy plik</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                  </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>