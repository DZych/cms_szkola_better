
<?php
include("includes/header.php");
include("includes/navbar.php");
?>



<div id="content-wrapper" class="d-flex flex-column">
<?php
if (isset($_SESSION['changepswd'])) {
    if ($_SESSION['changepswd'] == 1) {
        echo '
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Udało się zminić dane!</strong> 
        </div>
        <script type="text/javascript">console.log("1")</script>';
    }
    elseif ($_SESSION['changepswd'] == 2) {
        echo '
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Podane hasła</strong> nie są prawdiłowe!
        </div>
        <script type="text/javascript">console.log("2")</script>';
    }
    else{
        echo '<script type="text/javascript">console.log("3")</script>';
    }
    $_SESSION['changepswd']=3;
    //echo '<script type="text/javascript">console.log("3")</script>';
}
?>
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


            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Zdjęcie profilowe</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->


                            <?php

                            require_once("../config.php");

                            if(isset($_POST['edit_user_id'])){
                                $_SESSION['edit_user_id'] = $_POST['edit_user_id'];
                                $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_POST['edit_user_id'] . "";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                            }
                            else{
                                $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_SESSION['user_id'] . "";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                            }

                            if (mysqli_num_rows($result) == 1) {
                                $wiersz = mysqli_fetch_assoc($result);

                                echo '<img class="img-fluid rounded" src="data:image/jpeg;base64,' . base64_encode($wiersz['avatar']) . '" alt="..." />
                            
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <!-- Profile picture upload button-->

                            <form action="aktualizacja.php" method="POST" enctype="multipart/form-data">
                                <input type="file" name="image" />
                                </br>
                                </br>
                                <button class="btn btn-primary btn-sm" type="submit" name="submit">Dodaj nowy plik</button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Twoje dane</div>
                        <div class="card-body">
                            <form method="POST" action="aktualizacja.php">

                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Imię</label>
                                        <input class="form-control" id="inputFirstName" name="first_name" type="text" placeholder="Wprowadź swoję imię" value=' . $wiersz["first_name"] . ' required>
                                    </div>
                                    <!-- Form Group (last name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Nazwisko</label>
                                        <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Wprowadź swoję nazwisko" value=' . $wiersz["last_name"] . ' required>
                                    </div>
                                </div>
                                <!-- Form Row  -->
                                <div class="row gx-3 mb-3">

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Nowe hasło</label>
                                        <input class="form-control" id="inputOrgName" type="text" placeholder="Wprowadź hasło" value="" name="password1">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Powtórz nowe hasło</label>
                                        <input class="form-control" id="inputLocation" type="text" placeholder="Powtórz hasło" value="" name="password2">
                                    </div>
                                </div>
                                <!-- Form Group (email address)-->

                                
                                    <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="' . $wiersz['email'] . '" name="Email" required>
                                    </div>
                                    
                                

                                






                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Numer telefonu</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" name="phone" value=' . $wiersz['phone'] . ' required>
                                    </div>
                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Data urodzenia</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value=' . $wiersz['birth_date'] . ' required>
                                    </div>
                                </div>
                                <!-- Save changes button-->
                                
                                <button class="btn btn-primary" type="submit" name"Save_changes">Zapisz zmiany</button>
                            </form>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->



    </div>
    <script type="text/javascript">
        src = "js/password.js"
    </script>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
   
    ?>