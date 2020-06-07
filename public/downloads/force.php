<?php

$filename = $_REQUEST['file'];
$custom_name = $_REQUEST['custom_name'];
if (isset($filename) && $filename !== null) {
    $filename = basename($filename);
    if (!empty($filename) && file_exists($filename)) {
        // Define headers

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $custom_name = $custom_name . "." . $extension;

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $custom_name);
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($filename);
        exit;
    } else {
        return 'The file does not exist.';
    }
}