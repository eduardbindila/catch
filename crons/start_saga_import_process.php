<?php 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
require_once($_PATH['COMMON_BACKEND'].'saga_import_format.php');

//printError($vendorInvoicesData);


function parseJsonData($jsonData, $requestType, $processId) {
    $data = json_decode($jsonData, true);

    $result = [];

    foreach ($data[$requestType] as $entry) {
        $resultKey = ($requestType == 'iesiri') ? $entry['nrIesire'] : $entry['nrIntrare'];

        if (!isset($result[$resultKey])) {
            $result[$resultKey] = [
                'type' => $requestType,
                'code' => $entry['cod'],
                'invoice_id' => $resultKey,
                'date' => $entry['data'],
                'process_id' => $processId
            ];
        }
    }

    // Convertim rezultatul într-un array indexed
    $result = array_values($result);

    return $result;
}


//printError($clientInvoicesData['iesiri']);

if (empty($clientsData['clienti']) && empty($productsData['articole']) && empty($vendorsData['furnizori']) && empty($clientInvoicesData['iesiri']) && empty($vendorInvoicesData['intrari'])) {
    $startProcess = 0;
} else {


    // $startProcess = $QueryBuilder->insert(
    //     $conn,
    //     $options = array(
    //         "table" => "saga_import_processess",
    //         "keys" => ["overall_status"],
    //         "values" => [1]
    //     )
    // );


    $startProcess = 1;

}

if($startProcess) {
 
  $insertArray = [];
  


    if ($_GET["type"] == 4) {
        $insertArray[] = [$startProcess, 4, htmlspecialchars($clientInvoicesJson), 5];
        $combinedResult = parseJsonData($clientInvoicesJson, 'iesiri', $startProcess);

    } elseif ($_GET["type"] == 5) {

        $insertArray[] = [$startProcess, 5, htmlspecialchars($vendorInvoicesJson), 5];
        $combinedResult =  parseJsonData($vendorInvoicesJson, 'intrari', $startProcess);

    } else {
        $insertArray = [
            [$startProcess, 1, htmlspecialchars($clientsJson), 5],
            [$startProcess, 2, htmlspecialchars($productsJson), 5],
            [$startProcess, 3, htmlspecialchars($vendorsJson), 5],
            [$startProcess, 4, htmlspecialchars($clientInvoicesJson), 5],
            [$startProcess, 5, htmlspecialchars($vendorInvoicesJson), 5],
        ];

         $combinedResult = array_merge(
                parseJsonData($clientInvoicesJson, 'iesiri', $startProcess), 
                parseJsonData($vendorInvoicesJson, 'intrari', $startProcess));
    }

    //var_dump($combinedResult);


    // $insertProcessDetails = $QueryBuilder->insert(
    //     $conn,
    //     $options = array(
    //         "table" => "saga_import_details",
    //         "keys" => ["saga_process_id", "request_type_id", "request", "status"],
    //         "values" => $insertArray
    //     ),
    //     $multi = true
    // );

    // if($insertProcessDetails) {

    //     //var_dump($insertArray);

    //     $insertImportInvoices = $QueryBuilder->insert(
    //         $conn,
    //         $options = array(
    //             "table" => "saga_imported_invoices",
    //             "keys" => ["type", "code", "invoice_id", "date", "process_id"],
    //             "values" => $combinedResult
    //         ),
    //         $multi = true
    //     );

    // }


    //echo $conn->error;
}

echo $startProcess;

//printError($insertArray);

$QueryBuilder->closeConnection();

	
?>