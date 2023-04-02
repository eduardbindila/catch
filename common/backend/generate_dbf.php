<?php
require_once('../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

phpinfo();


// Define the header fields
$header = array(
    array('NR_NIR', 'C', 16),
    array('NR_INTRARE', 'C', 16),
    array('GESTIUNE', 'C', 4),
    array('DEN_GEST', 'C', 24),
    array('COD', 'C', 8),
    array('DATA', 'D'),
    array('SCADENT', 'D'),
    array('TIP', 'C', 1),
    array('TVAI', 'N', 1, 0),
    array('COD_ART', 'C', 16),
    array('DEN_TIP', 'C', 36),
    array('DEN_ART', 'C', 60),
    array('TVA_ART', 'N', 6, 3),
    array('UM', 'C', 5),
    array('CANTITATE', 'N', 14, 3),
    array('VALOARE', 'N', 15, 2),
    array('TVA', 'N', 15, 2),
    array('CONT', 'C', 20),
    array('PRET_VANZ', 'N', 16, 4),
    array('GRUPA', 'C', 16),
    array('TIP_DED', 'C', 3)
);

// Define the record
$record = array(
    "6506",
    "58000",
    "",
    "",
    "00498",
    "02/02/23",
    "",
    "0",
    "",
    "MARFA",
    "",
    "",
    "19.000",
    "",
    "19.000",
    "168.62",
    "32.04",
    "371",
    "0.0000",
    "",
    ""
);

// Create an array with the header and record
$data = array($header, $record);

// Open the file for writing
$file = dbase_create($_SERVER['DOCUMENT_ROOT'] . "/uploads/data.dbf", $header);

// Write the record to the file
dbase_add_record($file, $record);

// Close the file
dbase_close($file);

?>