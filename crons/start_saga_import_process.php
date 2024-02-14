<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

 $vendorRequirements = [
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => false],
        'DENUMIRE' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'COD_FISCAL' => ['type' => 'Character', 'max_length' => 13, 'optional' => true],
        'ANALITIC' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'ZS' => ['type' => 'Numeric', 'max_length' => 3, 'decimals' => 0, 'optional' => true],
        'LOCALITATE' => ['type' => 'Character', 'max_length' => 46, 'optional' => true],
        'ADRESA' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'BANCA' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'CONT_BANCA' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'FILIALA' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'AGENT' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_AGENT' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'TIP_TERT' => ['type' => 'Character', 'max_length' => 1, 'optional' => true],
        'TARA' => ['type' => 'Character', 'max_length' => 2, 'optional' => true],
        'TEL' => ['type' => 'Character', 'max_length' => 20, 'optional' => true],
        'EMAIL' => ['type' => 'Character', 'max_length' => 100, 'optional' => true],
        'IS_TVA' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => true],
    ];

    $clientRequirements = [
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => false],
        'DENUMIRE' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'COD_FISCAL' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'REG_COM' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'ANALITIC' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'ZS' => ['type' => 'Numeric', 'max_length' => 3, 'decimals' => 0, 'optional' => true],
        'DISCOUNT' => ['type' => 'Numeric', 'max_length' => 5, 'decimals' => 2, 'optional' => true],
        'LOCALITATE' => ['type' => 'Character', 'max_length' => 46, 'optional' => true],
        'ADRESA' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'JUDET' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'BANCA' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'CONT_BANCA' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'DELEGAT' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'BI_SERIE' => ['type' => 'Character', 'max_length' => 2, 'optional' => true],
        'BI_NUMAR' => ['type' => 'Character', 'max_length' => 8, 'optional' => true],
        'BI_POL' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'MASINA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'INF_SUPL' => ['type' => 'Character', 'max_length' => 100, 'optional' => true],
        'AGENT' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_AGENT' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'TIP_TERT' => ['type' => 'Character', 'max_length' => 1, 'optional' => true],
        'TARA' => ['type' => 'Character', 'max_length' => 2, 'optional' => true],
        'TEL' => ['type' => 'Character', 'max_length' => 20, 'optional' => true],
        'EMAIL' => ['type' => 'Character', 'max_length' => 100, 'optional' => true],
        'IS_TVA' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => true],
    ];

     $productRequirements = [
        'COD' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'DENUMIRE' => ['type' => 'Character', 'max_length' => 60, 'optional' => true],
        'UM' => ['type' => 'Character', 'max_length' => 5, 'optional' => true],
        'TVA' => ['type' => 'Numeric', 'max_length' => 5, 'decimals' => 2, 'optional' => true],
        'TIP' => ['type' => 'Character', 'max_length' => 2, 'optional' => true],
        'DEN_TIP' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'PRET_VANZ' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 4, 'optional' => true],
        'PRET_V_TVA' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 4, 'optional' => true],
        'COD_BARE' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'CANT_MIN' => ['type' => 'Numeric', 'max_length' => 14, 'decimals' => 3, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'COD_FE' => ['type' => 'Character', 'max_length' => 8, 'optional' => true],
        'COD_CPV' => ['type' => 'Character', 'max_length' => 10, 'optional' => true],
    ];

     $vendorInvoicesRequirements = [
        'NR_NIR' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'NR_INTRARE' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'GESTIUNE' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_GEST' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => true],
        'DATA' => ['type' => 'Date', 'optional' => true],
        'SCADENT' => ['type' => 'Date', 'optional' => true],
        'TIP' => ['type' => 'Character', 'max_length' => 1, 'optional' => true],
        'TVAI' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => true],
        'COD_ART' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'DEN_ART' => ['type' => 'Character', 'max_length' => 60, 'optional' => true],
        'MONEDA' => ['type' => 'Character', 'max_length' => 3, 'optional' => true],
        'CURS' => ['type' => 'Numeric', 'max_length' => 6, 'decimals' => 4, 'optional' => true],
        'UM' => ['type' => 'Character', 'max_length' => 5, 'optional' => true],
        'CANTITATE' => ['type' => 'Numeric', 'max_length' => 14, 'decimals' => 3, 'optional' => true],
        'DEN_TIP' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'TVA_ART' => ['type' => 'Numeric', 'max_length' => 2, 'decimals' => 0, 'optional' => true],
        'VALOARE' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'TOTAL' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'TVA' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'CONT' => ['type' => 'Character', 'max_length' => 20, 'optional' => true],
        'PRET_VANZ' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
    ];

     $clientInvoicesRequirements = [
        'NR_IESIRE' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => true],
        'DATA' => ['type' => 'Date', 'optional' => true],
        'SCADENT' => ['type' => 'Date', 'optional' => true],
        'TIP' => ['type' => 'Character', 'max_length' => 1, 'optional' => true],
        'TVAI' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => true],
        'GESTIUNE' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_GEST' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'COD_ART' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'DEN_ART' => ['type' => 'Character', 'max_length' => 60, 'optional' => true],
        'UM' => ['type' => 'Character', 'max_length' => 5, 'optional' => true],
        'CANTITATE' => ['type' => 'Numeric', 'max_length' => 14, 'decimals' => 3, 'optional' => true],
        'DEN_TIP' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'TVA_ART' => ['type' => 'Numeric', 'max_length' => 2, 'decimals' => 0, 'optional' => true],
        'MONEDA' => ['type' => 'Character', 'max_length' => 3, 'optional' => true],
        'CURS' => ['type' => 'Numeric', 'max_length' => 6, 'decimals' => 4, 'optional' => true],
        'VALOARE' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'TOTAL' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'TVA' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'CONT' => ['type' => 'Character', 'max_length' => 20, 'optional' => true],
        'PRET_VANZ' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
    ];


function validateData($list, $fieldRequirements, $requestType) {

    $validatedData = [];

    //echo $requestType;

    //print_r($list);

    foreach ($list as $one) {
        $validatedOne = [];

        foreach ($fieldRequirements as $fieldName => $requirements) {

            $camelCaseKey = lcfirst(str_replace('_', '', ucwords(strtolower($fieldName), '_')));
            
            if (array_key_exists($fieldName, $one)) {
                $fieldValue = $one[$fieldName];

                // Apply requirements for the 'Character' type
                if ($requirements['type'] === 'Character') {
                    $fieldValue = substr($fieldValue, 0, $requirements['max_length']);
                }

                // Apply requirements for the 'Numeric' type
                if ($requirements['type'] === 'Numeric') {
                    $fieldValue = (float)$fieldValue;
                    $fieldValue = number_format($fieldValue, $requirements['decimals'], '.', '');
                }

                $validatedOne[$camelCaseKey] = $fieldValue;
            } elseif (!$requirements['optional']) {
                // If the field is not present and it's not optional, set an empty string
                $validatedOne[$camelCaseKey] = "";
            }
        }

        // Add the validated vendor data to the result array
        $validatedData[] = $validatedOne; 
    }

    $validatedRequest[$requestType] = $validatedData;


    //printError($validatedRequest);

    return $validatedRequest;
}

$conn = $QueryBuilder->dbConnection();

$vendorInvoiceSelectionRule = "sii.invoice_id IS NULL AND vi.`date` >= '2024-01-01' and vi.inventory = 0 AND vi.`date` < CURDATE()";
$clientInvoiceSelectionRule = "sii.invoice_id IS NULL AND id.`DATA` >= '2024-01-01' AND id.`DATA` < CURDATE()";


/////////////////////
//                //
//VENDOR INVOICES//
//              //
/////////////////

$vendorInvoicesQueryPart = "
FROM vendor_invoices vi
JOIN vendor_invoice_items vii ON vi.id = vii.vendor_invoice_id
JOIN vendors v on vi.vendor = v.id
JOIN products pr on pr.id = vii.product_id
LEFT JOIN saga_imported_invoices sii ON vi.invoice_no = sii.invoice_id AND sii.type = 'intrari'
WHERE ".$vendorInvoiceSelectionRule;


//Vendor Invoices Fields
$vendorCode = "
CASE
    WHEN v.code IS NOT NULL AND v.code <> '' THEN v.code
    ELSE CONCAT('B2B-', v.id)
END AS COD
";
$vendorName = "v.name as DENUMIRE";


$vendorInvoiceNir = "vi.id  + 8000 as NR_NIR";
$vendorInvoiceNo = "vi.invoice_no as NR_INTRARE";
$vendorInvoiceCode = $vendorCode;
$vendorInvoiceDate = "vi.date as DATA";
$vendorInvoiceDueDate = "vi.due_date as SCADENT";
$vendorInvoiceProductCode = "product_id as COD_ART";
$vendorInvoiceProductName = "product_name as DEN_ART";
$vendorInvoiceGestiune = "CASE
    WHEN vii.type = 1 THEN '0002'
    ELSE ''
END GESTIUNE";
$vendorInvoiceProductQuantity = "quantity as CANTITATE";
$vendorInvoiceProductVAT = "CASE
    WHEN vi.vat = 0 THEN 0
    ELSE 19
END TVA_ART";
$vendorInvoiceProductValue = "vii.total_price as VALOARE";
$vendorInvoiceProductPrice = "vii.unit_price as PRET_VANZ";
$vendorInvoiceVAT = "
CASE
    WHEN vi.vat = 0 THEN 0
    ELSE vii.total_price*19/100
END AS TVA

";
$vendorInvoiceAccount = "
CASE
    WHEN vii.type = 2 OR vii.type = 3 then 4091
    ELSE (
        CASE 
            WHEN vii.reception = 1 then 327
            ELSE 371
        END
    )
END AS CONT

";

$vendorInvoiceProductTotal = "vii.total_price + CASE
    WHEN vi.vat = 0 THEN 0
    ELSE vii.total_price*19/100
END as TOTAL";

$vendorInvoiceCurrency = "CASE
    WHEN vi.currency = 'RON' then ''
    ELSE vi.currency
END AS MONEDA";



$vendorInvoiceExchangeRate = "CASE
    WHEN vi.currency = 'RON' then ''
    ELSE vi.exchange_rate
END AS CURS";

//Vendor Invoices Query
$selectVendorInvoicesQuery="SELECT  
    ".$vendorInvoiceNir.", 
    ".$vendorInvoiceNo.", 
    ".$vendorInvoiceCode.",  
    ".$vendorInvoiceDate.", 
    ".$vendorInvoiceProductCode.", 
    ".$vendorInvoiceProductName.",  
    ".$vendorInvoiceDueDate.",
    ".$vendorInvoiceProductQuantity.",  
    ".$vendorInvoiceProductVAT.", 
    ".$vendorInvoiceProductValue.", 
    ".$vendorInvoiceCurrency.",
    ".$vendorInvoiceExchangeRate.",
    ".$vendorInvoiceVAT.", 
    ".$vendorInvoiceProductTotal.", 
     ".$vendorInvoiceProductPrice.",
    ".$vendorInvoiceGestiune.", 
    ".$vendorInvoiceAccount."
    ".$vendorInvoicesQueryPart.";";


$vendorInvoicesQuery = $QueryBuilder->customQuery(
    $conn,
    $selectVendorInvoicesQuery
);

echo $selectVendorInvoicesQuery;


$vendorInvoicesData = validateData($vendorInvoicesQuery, $vendorInvoicesRequirements, 'intrari');



/////////////////////
//                //
//    VENDORS    //
//              //
/////////////////

$selectAllVendorsQuery = "
    SELECT distinct ".$vendorName.", ".$vendorCode."
    FROM vendors v
    WHERE id IN (
        SELECT DISTINCT vendor
        ".$vendorInvoicesQueryPart."
    );
    ";



// Use your custom query builder to execute the query
$vendorsQuery = $QueryBuilder->customQuery(
    $conn,
    $selectAllVendorsQuery
);
$vendorsData = validateData($vendorsQuery, $vendorRequirements, 'furnizori');

//echo $selectClientInvoicesQuery;
// printError($vendorsData);


/////////////////////
//                //
//CLIENT INVOICES//
//              //
/////////////////


$clientInvoicesQueryPart = "
from invoiced_data id
left join saga_imported_invoices sii  on id.`NR_IESIRE` = sii.invoice_id and sii.type = 'iesiri'
";

$selectClientInvoicesQuery = "
SELECT id.*, id.VALOARE + id.TVA as TOTAL ".
$clientInvoicesQueryPart."
WHERE ".$clientInvoiceSelectionRule;


// Use your custom query builder to execute the query
$clientInvoicesQuery = $QueryBuilder->customQuery(
    $conn,
    $selectClientInvoicesQuery
);

//echo $selectClientInvoicesQuery;

 $clientInvoicesData = validateData($clientInvoicesQuery, $clientInvoicesRequirements, 'iesiri');



/////////////////////
//                //
//    CLIENTS    //
//              //
/////////////////

$selectAllClientsQuery = "
   SELECT 
   distinct COD,
   c.name as DENUMIRE,
   c.fiscal_code as COD_FISCAL
    ".
$clientInvoicesQueryPart."
JOIN clients c ON id.`COD` = CASE WHEN c.saga_code > 0 THEN c.saga_code ELSE CONCAT('B2B-', c.id) end
WHERE ".$clientInvoiceSelectionRule;



// Use your custom query builder to execute the query
$clientsQuery = $QueryBuilder->customQuery(
    $conn,
    $selectAllClientsQuery
);
$clientsData = validateData($clientsQuery, $clientRequirements, 'clienti');



/////////////////////
//                //
//    PRODUCTS   //
//              //
/////////////////

//Products
$productCode = "prd.product_id as COD";
$productName = "prd.product_name as DENUMIRE";
$productVAT = "19 as TVA";
$productTip = "
CASE
    WHEN prd.isService = 1 THEN ''
    ELSE '01'
END AS TIP
";
$productTipName = "
CASE
    WHEN prd.isService = 1 THEN ''
    ELSE 'Marfuri'
END AS DEN_TIP
";


$selectAllProductsQuery = "
 SELECT DISTINCT COD_ART as COD, DENUMIRE, ".$productTip.",  ".$productVAT.", ".$productTipName."
    FROM (
         SELECT DISTINCT vii.product_id as COD_ART, pr.product_name as DENUMIRE, pr.isService 
        ".$vendorInvoicesQueryPart."
        UNION
       
         SELECT 
           DISTINCT COD_ART, p.product_name as DENUMIRE, p.isService
            ".
        $clientInvoicesQueryPart."
        join products p on id.`COD_ART` = p.id 
        WHERE ".$clientInvoiceSelectionRule."
    ) as prd;
";


//Use your custom query builder to execute the query
$productsQuery = $QueryBuilder->customQuery(
    $conn,
    $selectAllProductsQuery
);



$productsData = validateData($productsQuery, $productRequirements,'articole');

$productsJson = json_encode($productsData);

$clientsJson = json_encode($clientsData);

$vendorInvoicesJson = json_encode($vendorInvoicesData);

$vendorsJson = json_encode($vendorsData);

$clientInvoicesJson = json_encode($clientInvoicesData);


printError($vendorInvoicesData);


function parseJsonData($jsonData, $requestType) {
    $data = json_decode($jsonData, true);

    $result = [];

    foreach ($data[$requestType] as $entry) {
        $resultKey = ($requestType == 'iesiri') ? $entry['nrIesire'] : $entry['nrIntrare'];

        if (!isset($result[$resultKey])) {
            $result[$resultKey] = [
                'type' => $requestType,
                'code' => $entry['cod'],
                'invoice_id' => $resultKey,
                'date' => $entry['data']
            ];
        }
    }

    // Convertim rezultatul într-un array indexed
    $result = array_values($result);

    return $result;
}


if (empty($clientsData['clienti']) && empty($productsData['articole']) && empty($vendorsData['furnizori']) && empty($clientInvoicesData['iesiri']) && empty($vendorInvoicesData['intrari'])) {
    $startProcess = 0;
} else {



$startProcess = $QueryBuilder->insert(
    $conn,
    $options = array(
        "table" => "saga_import_processess",
        "keys" => ["overall_status"],
        "values" => [1]
    )
);

}

if($startProcess) {



    $insertArray = [
        [$startProcess, 1, htmlspecialchars($clientsJson), 5],
        [$startProcess, 2, htmlspecialchars($productsJson), 5],
        [$startProcess, 3, htmlspecialchars($vendorsJson), 5],
        [$startProcess, 4, htmlspecialchars($clientInvoicesJson), 5],
        [$startProcess, 5, htmlspecialchars($vendorInvoicesJson), 5],
    ];

    $insertProcessDetails = $QueryBuilder->insert(
        $conn,
        $options = array(
            "table" => "saga_import_details",
            "keys" => ["saga_process_id", "request_type_id", "request", "status"],
            "values" => $insertArray
        ),
        $multi = true
    );

    if($insertProcessDetails) {

        $combinedResult = array_merge(
            parseJsonData($clientInvoicesJson, 'iesiri'), 
            parseJsonData($vendorInvoicesJson, 'intrari'));



        $insertImportInvoices = $QueryBuilder->insert(
            $conn,
            $options = array(
                "table" => "saga_imported_invoices",
                "keys" => ["type", "code", "invoice_id", "date"],
                "values" => $combinedResult
            ),
            $multi = true
        );

    }


    //echo $conn->error;
}

echo $startProcess;

//printError($insertArray);

$QueryBuilder->closeConnection();

	
?>