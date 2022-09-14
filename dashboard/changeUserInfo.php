<?php
include("includes/header.php");
include("includes/navbar.php");
?>



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

            if (isset($_GET['new-user'])) {
                //początek

                echo '
                                    <div class="row justify-content-md-center">
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Dane nowego użytkownika</div>
                            <div class="card-body">
                                <form method="POST" action="userManagment/addNewUser.php">
    
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (first name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputFirstName">Imię</label>
                                            <input class="form-control" id="inputFirstName" name="first_name" type="text" placeholder="Wprowadź imię" value="" required>
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLastName">Nazwisko</label>
                                            <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Wprowadź nazwisko" value="" required>
                                        </div>
                                    </div>
                                    <!-- Form Row  -->
                                    <div class="row gx-3 mb-3">
    
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputOrgName">Nowe hasło</label>
                                            <input class="form-control" id="inputOrgName" type="password" placeholder="Wprowadź hasło" value="" name="password1" title="Hasło musi składać się z minimum 8 znaków w tym 1 duża litera, 1 liczba oraz 1 znak specjalny!" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,100}$">
                                        </div>
    
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLocation">Powtórz nowe hasło</label>
                                            <input class="form-control" id="inputLocation" type="password" placeholder="Powtórz hasło" value="" name="password2" title="Hasło musi składać się z minimum 8 znaków w tym 1 duża litera, 1 liczba oraz 1 znak specjalny!" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,100}$">
                                        </div>
                                    </div>
                                    <!-- Form Group (email address)-->                                
                                        <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="inputEmailAddress" type="email" placeholder="Wprowadź adress email" value="" name="Email" required>
                                        </div>
    
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputPhone">Numer telefonu</label>
                                            <input class="form-control" id="inputPhone" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="Nr. tel. 123-456-789" name="phone" value="" required>
                                        </div>
                                        <!-- Form Group (birthday)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Data urodzenia</label>
                                            <input class="form-control" id="inputBirthday" type="date" name="birthday" placeholder="Wprowadź date urodzenia" value="" required>
                                        </div>
                                    </div>

                                    <!-- Type of User-->
                                    <div class="mb-3">
                                        <label class="small mb-1">Typ użytkownika</label><br>
                                        <select class="form-control form-select-lg mb-3" name="userType" aria-label="Default select example">
                                            <option value="s" selected>Student</option>
                                            <option value="t">Nauczyciel</option>
                                            <option value="a">Administrator</option>
                                        </select>
                                    </div>

                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit" name"Add_user">Dodaj użytkownika</button>
                                </form>';
            }

            //koniec
            else {
                if (isset($_POST['edit_user_id']) || isset($_SESSION['last_edit_id'])) {
                    if (isset($_POST['edit_user_id'])) {
                        $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_POST['edit_user_id'] . "";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                        $_SESSION['edit_user_id'] = $_POST['edit_user_id'];
                    }
                    if (isset($_SESSION['last_edit_id'])) {
                        $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_SESSION['last_edit_id'] . "";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                        unset($_SESSION['last_edit_id']);
                    }
                } else {
                    $query = "SELECT * FROM " . $prefix . "_users WHERE user_id=" . $_SESSION['user_id'] . "";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                }

                if (mysqli_num_rows($result) == 1) {
                    $wiersz = mysqli_fetch_assoc($result);

                    $typ_uzytkownika = "";

                    $query = "SELECT * FROM " . $prefix . "_students WHERE user_id =" . $wiersz['user_id'] . ";";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    if (mysqli_num_rows($result) == 1) {
                        $typ_uzytkownika = "Uczeń";
                    }
                    $query = "SELECT * FROM " . $prefix . "_teachers WHERE user_id =" . $wiersz['user_id'] . ";";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    if (mysqli_num_rows($result) == 1) {
                        $typ_uzytkownika = "Nauczyciel";
                    }
                    $query = "SELECT * FROM " . $prefix . "_admins WHERE user_id =" . $wiersz['user_id'] . ";";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    if (mysqli_num_rows($result) == 1) {
                        $typ_uzytkownika = "Administrator";
                    }

                    echo '
                                    <div class="row">
                                    <div class="col-xl-4">
                                        <!-- Profile picture card-->
                                        <div class="card mb-4 mb-xl-0">
                                            <div class="card-header">Zdjęcie profilowe</div>
                                                <div class="card-body text-center">
                                                    <!-- Profile picture image-->
                                    <img class="img-fluid rounded" src="data:image/jpeg;base64,' . base64_encode($wiersz['avatar']) . '" alt="..." />                            
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
                                            <input class="form-control" id="inputFirstName" name="first_name" type="text" placeholder="Wprowadź imię" value=' . $wiersz["first_name"] . ' required>
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLastName">Nazwisko</label>
                                            <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Wprowadź nazwisko" value=' . $wiersz["last_name"] . ' required>
                                        </div>
                                    </div>
                                    <!-- Form Row  -->
                                    <div class="row gx-3 mb-3">
    
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputOrgName">Nowe hasło</label>
                                            <input class="form-control" id="inputOrgName" type="password" placeholder="Wprowadź hasło" value="" name="password1" title="Hasło musi składać się z minimum 8 znaków w tym 1 duża litera, 1 liczba oraz 1 znak specjalny!" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,100}$">
                                        </div>
    
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLocation">Powtórz nowe hasło</label>
                                            <input class="form-control" id="inputLocation" type="password" placeholder="Powtórz hasło" value="" name="password2" title="Hasło musi składać się z minimum 8 znaków w tym 1 duża litera, 1 liczba oraz 1 znak specjalny!" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,100}$">
                                        </div>
                                    </div>
                                    <!-- Form Group (email address)-->                                
                                        <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="inputEmailAddress" type="email" placeholder="Wprowadź adress email" value="' . $wiersz['email'] . '" name="Email" required>
                                        </div>
    
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputPhone">Numer telefonu</label>
                                            <input class="form-control" id="inputPhone" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="Numer telefonu w formacie 000-000-000" name="phone" value=' . $wiersz['phone'] . ' required>
                                        </div>
                                        <!-- Form Group (birthday)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Data urodzenia</label>
                                            <input class="form-control" id="inputBirthday" type="date" name="birthday" placeholder="Wprowadź date urodzenia" value=' . $wiersz['birth_date'] . ' required>
                                        </div>
                                    </div>

                                    <!-- Type of User-->
                                    <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Typ użytkownika</label>
                                    <input class="form-control" type="text" value="' . $typ_uzytkownika . '" name="UserType" disabled>
                                    </div>

                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit" name"Save_changes">Zapisz zmiany</button>
                                </form>';
                }
            }
            ?>
        </div>
    </div>
</div>
</div>


<?php
if (isset($_SESSION['changepswd'])) {
    if ($_SESSION['changepswd'] == 1) {
        echo '
        <div class="alert alert-success mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Udało się zminić dane!</strong> 
        </div>
        <script type="text/javascript">console.log("1")</script>';
    } elseif ($_SESSION['changepswd'] == 2) {
        echo '
        <div class="alert alert-danger mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Podane hasła</strong> nie są prawdiłowe!
        </div>
        <script type="text/javascript">console.log("2")</script>';
    }elseif ($_SESSION['changepswd'] == 4) {
        echo '
        <div class="alert alert-danger mt-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Podany adres email jest już przypisany do innego użytkownika. Poddaj inny email!</strong> 
        </div>
        <script type="text/javascript">console.log("2")</script>';
    }
    
    else {
        echo '<script type="text/javascript">console.log("3")</script>';
    }
    $_SESSION['changepswd'] = 3;
    //echo '<script type="text/javascript">console.log("3")</script>';
}
?>

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