<?php
include 'config.php';

function read_csv($filename) {
    $data = [];
    if (($handle = fopen(CSV_PATH . $filename, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}
?>