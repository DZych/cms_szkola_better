<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Klasa</th>
                        <th>Dodaj ocenę</th>
                        <th>Wyświetl oceny</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = "SELECT _students.student_id, _users.first_name, _users.last_name, _classes.name FROM _users INNER JOIN _students ON _users.user_id = _students.user_id INNER JOIN _student_class ON _student_class.student_id = _students.student_id INNER JOIN _classes ON _student_class.class_id = _classes.class_id";
                    $result = mysqli_query($link, $query);

                    if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $student) {
                    ?>
                            <tr>
                                <td><?= $student['first_name'] ?></td>
                                <td><?= $student['last_name'] ?></td>
                                <td><?= $student['name'] ?></td>
                                <td>
                                    <form action="grades_add.php" method="POST">
                                        <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">
                                        <button type="submit" name="add_grade_btn" class="btn btn-primary btn-sm">Dodaj</button>
                                    </form>
                                </td>
                                <td></td>

                            </tr>

                    <?php
                        }
                    } else {
                        echo "<h5> No Result Found </h5>";
                    }
                    ?>

                </tbody>
            </table>

        </div>
    </div>
</div>