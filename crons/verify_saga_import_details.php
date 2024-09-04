<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_format.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_functions.php');

//var_dump($_GET);

if ($_GET["type"] == 4) {
    $checkBody = checkJson($clientInvoicesData, 'iesiri');
    $clientJson = json_decode($clientsJson, true);

} elseif ($_GET["type"] == 5) {
     $checkBody = checkJson($vendorInvoicesData, 'intrari');
     $vendorJson = json_decode($vendorsJson, true);
}

$checkJson = json_encode($checkBody);



//var_dump($checkJson);

$url = requestUrl('verificare', $target);

$sagaRequest = callSaga($url, $checkJson);


$notificationId = $sagaRequest['notificationId'];

if($notificationId > 0) {
	sleep(2);
	$sagaCheckImportStatus = checkNotificationId($notificationId);	
} else {
	$sagaCheckImportStatus = 0;
}

// Decodează stringurile JSON în array-uri PHP
$sagaCheckImportStatus = json_decode($sagaCheckImportStatus, true);
$productsJson = json_decode($productsJson, true);

    $response = [
        'checkJson' => $sagaCheckImportStatus,
        'productsJson' => $productsJson,
        'clientJson' => isset($clientJson) ? $clientJson : [],
        'vendorJson' => isset($vendorJson) ? $vendorJson : [],
    ];

    // Encodează array-ul de răspuns în JSON
    echo json_encode($response);

?>