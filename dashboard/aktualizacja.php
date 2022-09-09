<?php
session_start();
require_once("../config.php");


// If file upload form is submitted 
$status = $statusMsg = '';

if (isset($_POST["submit"])) {
    echo 'test';
    $status = 'error';
    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Insert image content into database 
            $query = "UPDATE " . $prefix . "_users SET avatar = '" . $imgContent . "' WHERE user_id = '" . $_SESSION['user_id'] . "';";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
            $_SESSION['changepswd']= 1;

            if ($insert) {
                $status = 'success';
                $statusMsg = "File uploaded successfully.";
                
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
        echo "<script type='text/javascript'>alert('proszę wybrać obraz');</script>";
    }

    header("location:changeUserInfo.php");
}




// Display status message 

if ($_POST['password1'] === $_POST['password2']) {
    if (isset($_POST["Email"])) {
        $email =  $_POST['Email'];
        $password = $_POST['password2'];
        if ($_POST['password2'] == "") {
            $query = "UPDATE " . $prefix . "_users SET first_name = '" . $_POST['first_name'] . "' , last_name='" . $_POST['last_name'] . "' , email='" . $_POST['Email'] . "' , birth_date='" . $_POST['birthday'] . "' , phone='" . $_POST['phone'] . "'  WHERE user_id = '" . $_SESSION['user_id'] . "';";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
        } else {
            $query = "UPDATE " . $prefix . "_users SET first_name = '" . $_POST['first_name'] . "' , last_name='" . $_POST['last_name'] . "' , password='" . password_hash($_POST['password2'], PASSWORD_DEFAULT) . "',email='" . $_POST['Email'] . "' , birth_date='" . $_POST['birthday'] . "' , phone='" . $_POST['phone'] . "'  WHERE user_id = '" . $_SESSION['user_id'] . "';";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
        }
        $_SESSION['changepswd']= 1;
        header("location:changeUserInfo.php");
        
        
    }
}
else{
    $_SESSION['changepswd']= 2;
    header("location:changeUserInfo.php");
}

?>
