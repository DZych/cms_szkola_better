<?php
include("includes/header.php");
include("includes/navbar.php");
?>

<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php
        include('includes/topbar/topbar.php');
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

$query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_SESSION['user_id'] . "";
$result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) == 1) {
    $wiersz = mysqli_fetch_assoc($result);

    echo '<img class="img-fluid rounded" src="data:image/jpeg;base64,'.base64_encode($wiersz['avatar']).'" alt="..." />';
}





                            ?>
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <!-- Profile picture upload button-->

                            <form action='aktualizacja.php' method="POST" enctype="multipart/form-data">
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
                                        <input class="form-control" id="inputFirstName" type="text" placeholder="Wprowadź swoję imię" value=<?php echo $_SESSION["first_name"] ?>>
                                    </div>
                                    <!-- Form Group (last name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Nazwisko</label>
                                        <input class="form-control" id="inputLastName" type="text" placeholder="Wprowadź swoję nazwisko" value=<?php echo $_SESSION["last_name"] ?>>
                                    </div>
                                </div>
                                <!-- Form Row  -->
                                <div class="row gx-3 mb-3">

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Nowe hasło</label>
                                        <input class="form-control" id="inputOrgName" type="text" placeholder="Wprowadź hasło" value="">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Powtórz nowe hasło</label>
                                        <input class="form-control" id="inputLocation" type="text" placeholder="Powtórz hasło" value="">
                                    </div>
                                </div>
                                <!-- Form Group (email address)-->

                                <?php
                                require_once("../config.php");

                                $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_SESSION['user_id'] . "";
                                $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                                if (mysqli_num_rows($result) == 1) {
                                    $wiersz = mysqli_fetch_assoc($result);

                                    echo '
                                    <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="' . $wiersz['email'] . '" name="Email">
                                    </div>
                                    ';
                                }

                                ?>






                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Numer telefonu</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                    </div>
                                    <!-- Form Group (birthday)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Data urodzenia</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="06/10/1988">
                                    </div>
                                </div>
                                <!-- Save changes button-->
                                <button class="btn btn-primary" type="submit">Zapisz zmiany</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->



    </div>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>