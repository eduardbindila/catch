<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

header('Content-Type: application/json');

$valuesArray = [];
$multiple = true;

if(!isset($_POST['products'])) {

        $valuesArray = array(
                'product_id' => '',
                'vendor_invoice_id' => $_POST['vendor_invoice_id'],
                'quantity' => 1,
                'external_item_name' => $_POST['external_item_name']
        );

        $multiple = false;
} else {


        foreach ($_POST['products'] as $key => $value) {

                $localArray = array(
                        'product_id' => $value,
                        'vendor_invoice_id' => $_POST['vendor_invoice_id'],
                        'quantity' => $_POST['allProductsData'][$value]['quantity'],
                        'external_item_name' =>''
                );

                array_push($valuesArray, $localArray);
        }
}


$conn = $QueryBuilder->dbConnection();

$query = $QueryBuilder->insert(
        $conn,
        $options = array(
                "table" => "vendor_invoice_items",
                "keys" => ["product_id", "vendor_invoice_id", 'quantity', 'external_item_name'],
                "values" => $valuesArray
        ),
        $multi = $multiple
);

$response = [
        'success' => false
];

if($query){
        $response['success'] = true;

        if(is_numeric($query)) {
                $response['insertId'] = (int)$query;
        }
} else {
        $errorMessage = mysqli_error($conn);

        if(empty($errorMessage)) {
                $errorMessage = 'Unknown database error.';
        }

        http_response_code(500);
        $response['error'] = $errorMessage;
}

echo json_encode($response);

$QueryBuilder->closeConnection();


?>