<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_format.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_functions.php');


if ($_GET["type"] == 4) {
    $requestJson = $clientInvoicesJson;
    $requestData = $clientInvoicesData;
    $requestType = 'iesiri';

} elseif ($_GET["type"] == 5) {
    $requestJson = $vendorInvoicesJson;
    $requestData = $vendorInvoicesData;
    $requestType = 'intrari';
}


if ($requestData) {
    // Verificăm dacă există cheia 'iesiri' și dacă este un array nevid
    if (isset($requestData[$requestType]) && is_array($requestData[$requestType]) && !empty($requestData[$requestType])) {
        // Accesăm prima dată din array-ul $requestType
        $firstEntry = $requestData[$requestType][0];

        $date = $firstEntry['data'];
    } else {
        echo "no date";
    }
} else {
    echo "Error decoding json";
}

// printError($requestJson);


if(isset($_GET["processId"]) && $_GET["processId"] <> 0) {

	$startProcess = $_GET["processId"];

} else{
	$startProcess = $QueryBuilder->insert(
        $conn,
        $options = array(
            "table" => "saga_import_processess",
            "keys" => ["overall_status"],
            "values" => [1]
        )
    );

    if($startProcess) {

        $insertImportInvoices = $QueryBuilder->insert(
            $conn,
            $options = array(
                "table" => "saga_imported_invoices",
                "keys" => ["type", "code", "invoice_id", "date", "process_id"],
                "values" => [$_GET['type'], $_GET['code'], $_GET['invoice'], $date, $startProcess]
            )
        );

        //printError($insertImportInvoices);
	}
}



//printError($startProcess);

if($startProcess) {

	$insertProcessDetails = $QueryBuilder->insert(
        $conn,
        $options = array(
            "table" => "saga_import_details",
            "keys" => ["saga_process_id", "request_type_id", "request", "status"],
            "values" =>[$startProcess, $_GET['type'], htmlspecialchars($requestJson), 5]
        )
    );

//printError($insertProcessDetails);

}


$url = requestUrl($requestType, $target);

$sagaRequest = callSaga($url, $requestJson);

//printError($sagaRequest);

$notificationId = $sagaRequest['notificationId'];

$status = $sagaRequest['status'];
$response_error = isset($sagaRequest['response_error']) ? $sagaRequest['response_error'] : null ;

if($notificationId > 0) {
	sleep(2);

	


	$sagaCheckImportStatus = checkNotificationId($notificationId);	


	 if (json_decode($sagaCheckImportStatus) !== null && json_last_error() === JSON_ERROR_NONE) {
                // Decodificare JSON și afișare
                $decodedData = json_decode($sagaCheckImportStatus, true);

                //print_r($decodedData);

                // Verificare dacă există cheia 'notificationId'
                if (isset($decodedData['status'])) {
                    // Extrage valoarea asociată cheii "notificationId"
                   if($decodedData['status'] == "OK")
                   {
                        $status = 2;
                   }
                        
                    elseif($decodedData['status'] == "KO")
                    {
                        $status = 3; 
                        $response_error = $decodedData['message'];
                    }
                        
                    elseif($decodedData['status'] == "pending")
                        $status="1";
                }
            } 

	// Actualizare în baza de date
        $updateRequests = $QueryBuilder->update(
            $conn,
            $options = array(
                "table" => "saga_import_details",
                "set" => [
                    "`status`=" . $status,
                    "`response_notification`='" . $notificationId . "'",
                    "`response_error`='" . $response_error . "'"
                ],
                "where" => "id = " . $insertProcessDetails
            )
        );



} else {
	$sagaCheckImportStatus = 0;
}


// Decodează stringurile JSON în array-uri PHP
$sagaCheckImportStatus = json_decode($sagaCheckImportStatus, true);

// Verifică dacă decodarea a fost cu succes
if (json_last_error() === JSON_ERROR_NONE && json_last_error() === JSON_ERROR_NONE) {
    // Creează array-ul de răspuns
    // Encodează array-ul de răspuns în JSON
    echo json_encode($sagaCheckImportStatus);
} else {
    // Gestionează eroarea de decodare JSON
    echo json_encode(['error' => 'Invalid JSON format']);
}

?>