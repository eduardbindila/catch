<?php 
require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


if(isset($_GET['f'])) {
    $file = 'uploads/' . $_GET['f'];

    



if (file_exists($file)) {
     header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($file) . '"');
    readfile($file);
} else {
    echo 'File not found.';
}
}
?>

