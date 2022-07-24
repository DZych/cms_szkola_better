<?php
    // Include the database configuration file
    include('../config.php');
    $statusMsg = '';
    $class_lesson_id = $_SESSION['class_lesson_id'];

    // File upload path
    $targetDir = "../uploads/zajecia/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    if(isset($_POST["upload"]) && !empty($_FILES["file"]["name"])){
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf','txt','docx');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
                $query = "INSERT INTO `_files`(`filename`,`filepath`) VALUES('".$fileName."','".$targetFilePath."');";
                $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                if($result == true){
                    $query = "INSERT INTO `_class_lessons_files` (`file_id`, `class_lesson_id`) VALUES ('".mysqli_insert_id($link)."', '".$class_lesson_id."');";
                    $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                }
            }
        }
    }

    // Display status message
    echo $statusMsg;
?>