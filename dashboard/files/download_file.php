<?php
$name= $_GET['name'];

    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=\"" . basename($name) . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header("Content-Length: ".filesize("../../uploads/zajecia/$name"));
    ob_clean();
    flush();
    readfile("../../uploads/zajecia/".$name); //showing the path to the server where the file is to be download
    exit;
?>