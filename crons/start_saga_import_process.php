<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

 $vendorRequirements = [
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

    $clientRequirements = [
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => false],
        'DENUMIRE' => ['type' => 'Character', 'max_length' => 48, 'optional' => false],
        'COD_FISCAL' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'REG_COM' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'ANALITIC' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
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
        'TIP_TERT' => ['type' => 'Character', 'max_length' => 1, 'optional' => false],
        'TARA' => ['type' => 'Character', 'max_length' => 2, 'optional' => false],
        'TEL' => ['type' => 'Character', 'max_length' => 20, 'optional' => true],
        'EMAIL' => ['type' => 'Character', 'max_length' => 100, 'optional' => true],
        'IS_TVA' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => false],
    ];

     $productRequirements = [
        'COD' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'DENUMIRE' => ['type' => 'Character', 'max_length' => 60, 'optional' => false],
        'UM' => ['type' => 'Character', 'max_length' => 5, 'optional' => false],
        'TVA' => ['type' => 'Numeric', 'max_length' => 5, 'decimals' => 2, 'optional' => false],
        'TIP' => ['type' => 'Character', 'max_length' => 2, 'optional' => false],
        'DEN_TIP' => ['type' => 'Character', 'max_length' => 36, 'optional' => false],
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
        'NR_INTRARE' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'GESTIUNE' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_GEST' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => false],
        'DATA' => ['type' => 'Date', 'optional' => false],
        'SCADENT' => ['type' => 'Date', 'optional' => false],
        'TIP' => ['type' => 'Character', 'max_length' => 1, 'optional' => false],
        'TVAI' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => false],
        'COD_ART' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
        'DEN_ART' => ['type' => 'Character', 'max_length' => 60, 'optional' => false],
        'UM' => ['type' => 'Character', 'max_length' => 5, 'optional' => true],
        'CANTITATE' => ['type' => 'Numeric', 'max_length' => 14, 'decimals' => 3, 'optional' => false],
        'DEN_TIP' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'TVA_ART' => ['type' => 'Numeric', 'max_length' => 2, 'decimals' => 0, 'optional' => false],
        'VALOARE' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => false],
        'TVA' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => false],
        'CONT' => ['type' => 'Character', 'max_length' => 20, 'optional' => false],
        'PRET_VANZ' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => true],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
    ];

     $clientInvoicesRequirements = [
        'NR_IESIRE' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'COD' => ['type' => 'Character', 'max_length' => 8, 'optional' => false],
        'DATA' => ['type' => 'Date', 'optional' => false],
        'SCADENT' => ['type' => 'Date', 'optional' => false],
        'TIP' => ['type' => 'Character', 'max_length' => 1, 'optional' => false],
        'TVAI' => ['type' => 'Numeric', 'max_length' => 1, 'decimals' => 0, 'optional' => false],
        'GESTIUNE' => ['type' => 'Character', 'max_length' => 4, 'optional' => true],
        'DEN_GEST' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'COD_ART' => ['type' => 'Character', 'max_length' => 16, 'optional' => false],
        'DEN_ART' => ['type' => 'Character', 'max_length' => 60, 'optional' => false],
        'UM' => ['type' => 'Character', 'max_length' => 5, 'optional' => false],
        'CANTITATE' => ['type' => 'Numeric', 'max_length' => 14, 'decimals' => 3, 'optional' => false],
        'DEN_TIP' => ['type' => 'Character', 'max_length' => 36, 'optional' => true],
        'TVA_ART' => ['type' => 'Numeric', 'max_length' => 2, 'decimals' => 0, 'optional' => false],
        'VALOARE' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => false],
        'TVA' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => false],
        'CONT' => ['type' => 'Character', 'max_length' => 20, 'optional' => false],
        'PRET_VANZ' => ['type' => 'Numeric', 'max_length' => 15, 'decimals' => 2, 'optional' => false],
        'GRUPA' => ['type' => 'Character', 'max_length' => 16, 'optional' => true],
    ];


function validateData($list, $fieldRequirements) {
   
//var_dump($list);
    $validatedData = [];

    foreach ($list as $one) {
        $validatedOne = [];

        foreach ($fieldRequirements as $fieldName => $requirements) {
            
            if (array_key_exists($fieldName, $one)) {
                $fieldValue = $one[$fieldName];

                // Apply requirements for the 'Character' type
                if ($requirements['type'] === 'Character') {
                    $fieldValue = substr($fieldValue, 0, $requirements['max_length']);
                }

                // Apply requirements for the 'Numeric' type
                if ($requirements['type'] === 'Numeric') {
                    $fieldValue = number_format($fieldValue, $requirements['decimals'], '.', '');
                }

                $validatedOne[$fieldName] = $fieldValue;
            } elseif (!$requirements['optional']) {
                // If the field is not present and it's not optional, set an empty string
                $validatedOne[$fieldName] = "";
            }
        }

        // Add the validated vendor data to the result array
        $validatedData[] = $validatedOne;
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
JOIN products pr on pr.id = vii.product_id
LEFT JOIN saga_imported_invoices sii ON vi.id = sii.invoice_id AND sii.type = 'vendor'
WHERE ".$vendorInvoiceSelectionRule;


$clientInvoicesQueryPart = "
from packages p 
join package_items pi1 on p.id = pi1.package_id and p.package_status_id = 4
join quotes q on q.id = p.quote_id
left join quote_items qi on pi1.quote_item_id = qi.id 
JOIN products pr on pr.id = qi.product_id
JOIN clients c on c.id = q.client_id
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
$vendorName = "v.name as DENUMIRE";

//Clients
$clientCode = "
CASE
    WHEN c.saga_code IS NOT NULL AND c.saga_code <> '' THEN c.saga_code
    ELSE CONCAT('B2B-', c.id)
END AS COD
";
$clientName = "c.name as DENUMIRE";


//Products
$productCode = "prd.product_id as COD";
$productName = "prd.product_name as DENUMIRE";
$productVAT = "19 as TVA";
$productTip = "
CASE
    WHEN prd.isService = 1 THEN 704
    ELSE 371
END AS TIP
";
$productTip = "
CASE
    WHEN prd.isService = 1 THEN 'Servicii vandute'
    ELSE 'Marfuri'
END AS DEN_TIP
";


//Vendor Invoices
$vendorInvoiceNir = "vi.id  + 8000 as NR_NIR";
$vendorInvoiceNo = "vi.invoice_no as NR_INTRARE";
$vendorInvoiceCode = $vendorCode;
$vendorInvoiceDate = "vi.date as DATA";
$vendorInvoiceDueDate = "vi.due_date as SCADENT";
$vendorInvoiceProductCode = "product_id as COD_ART";
$vendorInvoiceProductName = "product_name as DEN_ART";
$vendorInvoiceProductQuantity = "quantity as CANTITATE";
$vendorInvoiceProductVAT = "19 as TVA_ART";
$vendorInvoiceProductValue = "vii.total_price";
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
END AS TVA

";

//Client Invoices
$clientInvoiceNo = "
CASE 
    WHEN c.country = 'RO' THEN CONCAT('RON-', p.`Invoice Number`)
    ELSE CONCAT('EXT-', p.`Invoice Number`)
END
";
$clientInvoiceClientCode = $clientCode;
$clientInvoiceDate = "p.invoice_date as DATA";
$clientInvoiceDueDate = "p.due_date as SCADENT";
$clientInvoiceProductCode = "product_id as COD_ART";
$clientInvoiceProductName = "product_name as DEN_ART";
$clientInvoiceProductQuantity = "pi1.package_quantity as CANTITATE";
$clientInvoiceProductVAT = $vendorInvoiceProductVAT;
// $clientInvoiceProductValue = " as DEN_ART";
// $clientInvoiceVAT = "vii.total_price*19/100 AS TVA";



//Querys
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
    ".$vendorInvoiceVAT.",  
    ".$vendorInvoiceAccount."


    ".$vendorInvoicesQueryPart.";";


$selectClientInvoicesQuery="
    SELECT * 
    ".$clientInvoicesQueryPart;

$selectAllProductsQuery = "
 SELECT DISTINCT ".$productCode.", ".$productName.", ".$productTip.",  ".$productVAT."
    FROM (
         SELECT DISTINCT vii.product_id, pr.product_name, pr.isService 
        ".$vendorInvoicesQueryPart."
        UNION
        SELECT DISTINCT qi.product_id, pr.product_name, pr.isService
        ".$clientInvoicesQueryPart."
    ) as prd;
";


$selectAllClientsQuery = "
    SELECT distinct ".$clientName.", ".$clientCode."
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


// // Use your custom query builder to execute the query
// $vendorsQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectAllVendorsQuery
// );
// $vendorsData = validateData($vendorsQuery, $vendorRequirements);


// // Use your custom query builder to execute the query
// $clientsQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectAllClientsQuery
// );
//$clientsData = validateData($clientsQuery, $clientRequirements);


// Use your custom query builder to execute the query
// $productsQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectAllProductsQuery
// );

// $productsData = validateData($productsQuery, $productRequirements);

// // Use your custom query builder to execute the query
// $vendorInvoicesQuery = $QueryBuilder->customQuery(
//     $conn,
//     $selectVendorInvoicesQuery
// );




// Use your custom query builder to execute the query
$clientInvoicesQuery = $QueryBuilder->customQuery(
    $conn,
    $selectClientInvoicesQuery
);

 $clientInvoicesData = validateData($clientInvoicesQuery, $clientInvoicesRequirements);

echo $selectVendorInvoicesQuery;
printError($clientInvoicesQuery);

$QueryBuilder->closeConnection();


	
?>