<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_functions.php');


//var_dump($_POST['json']);


// Decodificăm JSON-ul într-un array asociativ
$jsonArray = $_POST['json'];

if ($jsonArray) {
    // Obținem toate cheile obiectului JSON
    $keys = array_keys($jsonArray);

    // Accesăm prima cheie
    $firstKey = $keys[0];
} else {
    echo 0;
}


$url = requestUrl($firstKey, $target);

$sagaRequest = callSaga($url, json_encode($_POST['json']));

$notificationId = $sagaRequest['notificationId'];

if($notificationId > 0) {
	sleep(2);
	$sagaCheckImportStatus = checkNotificationId($notificationId);	
} else {
	$sagaCheckImportStatus = 0;
}


echo json_encode($sagaCheckImportStatus);

?>