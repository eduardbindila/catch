<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');




function validateVendorData($vendorsList) {
    $fieldRequirements = [
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => false],
        'DENUMIRE' => ['type' => 'Character', 'max_length' => 48, 'optional' => false],
        'COD_FISCAL' => ['type' => 'Character', 'max_length' => 13, 'optional' => false],
        'ANALITIC' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'ZS' => ['type' => 'Numeric', 'max_length' => 3, 'decimals' => 0, 'optional' => true],
        'LOCALITATE' => ['type' => 'Character', 'max_length' => 46, 'optional' => true],
        'ADRESA' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'BANCA' => ['type' => 'Character', 'max_length' => 48, 'optional' => true],
        'CONT_BANCA' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'FILIALA' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'AGENT' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_AGENT' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'TIP_TERT' => ['type' => 'Character', 'max_length' => 1, 'optional' => false],
        'TARA' => ['type' => 'Character', 'max_length' => 2, 'optional' => false],
        'TEL' => ['type' => 'Character', 'max_length' => 20, 'optional' => true],
        'EMAIL' => ['type' => 'Character', 'max_length' => 100, 'optional' => true],
        'IS_TVA' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => false],
    ];

    $validatedData = [];

    foreach ($vendorsList as $vendor) {
        $validatedVendor = [];

        foreach ($fieldRequirements as $fieldName => $requirements) {
            
            if (array_key_exists($fieldName, $vendor)) {
                $fieldValue = $vendor[$fieldName];

                // Apply requirements for the 'Character' type
                if ($requirements['type'] === 'Character') {
                    $fieldValue = substr($fieldValue, 0, $requirements['max_length']);
                }

                // Apply requirements for the 'Numeric' type
                if ($requirements['type'] === 'Numeric') {
                    $fieldValue = number_format($fieldValue, $requirements['decimals'], '.', '');
                }

                $validatedVendor[$fieldName] = $fieldValue;
            } elseif (!$requirements['optional']) {
                // If the field is not present and it's not optional, set an empty string
                $validatedVendor[$fieldName] = "";
            }
        }

        // Add the validated vendor data to the result array
        $validatedData[] = $validatedVendor;
    }

    return $validatedData;
}

$conn = $QueryBuilder->dbConnection();

$vendorInvoiceSelectionRule= "sii.invoice_id IS NULL AND vi.`date` >= CURDATE() - INTERVAL 10 WEEK AND vi.`date` < CURDATE()";

$clientInvoiceSelectionRule = "sii.invoice_id IS NULL AND p.invoice_date  >= CURDATE() - INTERVAL 10 WEEK AND p.invoice_date < CURDATE()";

$vendorInvoicesQueryPart = "
FROM vendor_invoices vi
JOIN vendor_invoice_items vii ON vi.id = vii.vendor_invoice_id
JOIN vendors v on vi.vendor = v.id
LEFT JOIN saga_imported_invoices sii ON vi.id = sii.invoice_id AND sii.type = 'vendor'
WHERE ".$vendorInvoiceSelectionRule;


$clientInvoicesQueryPart = "
from packages p 
join package_items pi1 on p.id = pi1.package_id and p.package_status_id = 4
join quotes q on q.id = p.quote_id
left join quote_items qi on pi1.quote_item_id = qi.id 
LEFT JOIN saga_imported_invoices sii on pi1.id = sii.invoice_id AND sii.type = 'client'
WHERE ". $clientInvoiceSelectionRule;


//SQL Variables mapping


//Vendors
$vendorCode = "
CASE
    WHEN v.code IS NOT NULL AND v.code <> '' THEN v.code
    ELSE CONCAT('B2B-', v.id)
END AS COD
";

$vendorName = "
v.name as DENUMIRE
";

//Clients



//Querys
$selectVendorInvoicesQuery="
    SELECT * 
    ".$vendorInvoicesQueryPart;


$selectClientInvoicesQuery="
    SELECT * 
    ".$clientInvoicesQueryPart;

$selectAllProductsQuery = "
    SELECT distinct *
    FROM products p
    WHERE id IN (
        SELECT DISTINCT product_id
        ".$vendorInvoicesQueryPart."

        UNION

        SELECT DISTINCT product_id
        ".$clientInvoicesQueryPart."
    );";


$selectAllClientsQuery = "
    SELECT distinct *
    FROM clients c
    WHERE id IN (
        
        SELECT DISTINCT client_id
       ".$clientInvoicesQueryPart."
    );";


$selectAllVendorsQuery = "
    SELECT distinct ".$vendorName.", ".$vendorCode."
    FROM vendors v
    WHERE id IN (
        SELECT DISTINCT vendor
        ".$vendorInvoicesQueryPart."
    );
    ";

//echo $selectAllProductsQuery;

// Use your custom query builder to execute the query
$vendorsQuery = $QueryBuilder->customQuery(
    $conn,
    $selectAllVendorsQuery
);


// echo $selectAllVendorsQuery;
printError($vendorsQuery);

$vendorData = validateVendorData($vendorsQuery);


printError($vendorData);


// // Use your custom query builder to execute the query
// $clientsQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectAllClientsQuery
// );

// // Use your custom query builder to execute the query
// $productsQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectAllProductsQuery
// );

// // Use your custom query builder to execute the query
// $vendorInvoicesQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectVendorInvoicesQuery
// );


// // Use your custom query builder to execute the query
// $clientInvoicesQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectVendorInvoicesQuery
// );

$QueryBuilder->closeConnection();


	
?>