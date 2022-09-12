<?php
session_start();
include("../../config.php");


if (isset($_POST['Add_news'])) {

    if (isset($_FILES["file"])) {
        $targetDir = "../../uploads/news/";
        $fileName = random_string(50) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (!empty($_FILES["file"]["name"])) {
            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    $query = "INSERT INTO " . $prefix . "_news
                            (title, content, image)
                            VALUES ('" . $_POST['title'] . "', '" . $_POST['content'] . "', '" . $targetFilePath . "');";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    unset($_FILES["file"]["name"]);
                    $_SESSION['news_message'] = '<div class="alert alert-success mt-2">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Artykuł został pomyślnie dodane!</strong> 
                            </div>';
                    header("location:../newsManagement.php");
                }
            }
        } else {
            $query = "INSERT INTO " . $prefix . "_news
                    (title, content)
                    VALUES ('" . $_POST['title'] . "', '" . $_POST['content'] . "');";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

            $_SESSION['news_message'] = '<div class="alert alert-success mt-2">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Artykuł został pomyślnie dodane!</strong> 
                    </div>';

            header("location:../newsManagement.php");
        }
    }
}
if (isset($_POST['edit_news'])) {
    if (isset($_FILES["file"])) {
        $targetDir = "../../uploads/news/";
        $fileName = random_string(50) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (!empty($_FILES["file"]["name"])) {
            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    $query = "UPDATE " . $prefix . "_news
                            SET title='" . $_POST['title'] . "', content='" . $_POST['content'] . "', image='" . $targetFilePath . "' WHERE news_id=" . $_SESSION['edit_news_id'] . ";";
                    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
                    unset($_FILES["file"]["name"]);

                    $_SESSION['news_message'] = '<div class="alert alert-success mt-2">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Dane zostały zaktualizowane!</strong>
                            </div>';

                    header("location:../newsManagement.php");
                }
            }
        } else {
            $query = "UPDATE " . $prefix . "_news
                    SET title='" . $_POST['title'] . "', content='" . $_POST['content'] . "' WHERE news_id=" . $_SESSION['edit_news_id'] . ";";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
            $_SESSION['news_message'] = '<div class="alert alert-success mt-2">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Dane zostały zaktualizowane!</strong>
                            </div>';
            header("location:../newsManagement.php");
        }
    }
}


function random_string($length)
{
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}
