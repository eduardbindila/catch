<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);



// Obține datele postate de la client
$data = json_decode($_POST['data'], true);

// Extrage array-ul de produse din datele primite
$filteredRows = $data;


// Construiește array-ul de ID-uri de produse pentru verificare
$productIdsForCheck = array_map(function ($row) {
    return explode("\t", $row)[0];
}, $filteredRows);

// Escapare SQL (pentru a preveni SQL injection)
$escapedProductIdsForCheck = array_map(function ($id) {
    return (int) $id;
}, $productIdsForCheck);


// Construiește un șir de produse escapat pentru a fi folosit în clauza IN
$inClause = implode(",", $escapedProductIdsForCheck);


$query = "SELECT id, CASE WHEN id IS NOT NULL THEN '1' ELSE '0' END AS product_exists FROM products WHERE id IN ($inClause) order by product_exists asc";

//echo $query;

// Execută query-ul
$result = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);

// Construiește array-ul de ID-uri de produse existente
$existingProductIds = [];

//printError($result);
// Populează array-ul $existingProductIds cu rezultatele din query
// Populează array-ul $existingProductIds cu rezultatele din query
foreach ($result as $row) {
    $existingProductIds[$row['id']] = (int) $row['product_exists'];
}

// Construiește array-ul de obiecte pentru datele procesate
$dataArray = [];

// Adaugă informații despre existența produselor în dataArray
foreach ($filteredRows as $row) {
    $values = explode("\t", $row);
    $product_id = $values[0];
    $quantity = $values[1];
    $price = $values[2];
    $total_price = $price * $quantity;

    $exists = isset($existingProductIds[$product_id]) ? $existingProductIds[$product_id] : 0;
    $dataArray[] = ['product_id' => $product_id, 'quantity' => $quantity,'price' => $price,'total_price' => $total_price, 'exists' => $exists];
}

usort($dataArray, function($a, $b) {
    return $a['exists'] == 'Exists' ? -1 : 1;
});

// Întoarce rezultatul ca JSON
echo json_encode($dataArray);

	//echo $conn->error;

	$QueryBuilder->closeConnection();


?>


