<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = __DIR__ . '/downloads/' . $file;

    if (file_exists($filepath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        readfile($filepath);
        exit;
    } else {
        echo "File tidak ditemukan!";
    }
} else {
    echo "File tidak tersedia!";
}
?>
