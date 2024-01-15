<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();

//printError($_POST);

$query = '
UPDATE products p
JOIN vendor_invoice_items vii ON vii.product_id = p.id
JOIN vendor_invoices vi ON vii.vendor_invoice_id = vi.id
 LEFT JOIN (
    SELECT product_id, SUM(reserved_stock) AS total_reserved_quantity
    FROM quote_items
    WHERE reserved_stock != 0
    GROUP BY product_id
) qi ON p.id = qi.product_id
SET
  vii.delivered_quantity = vii.quantity - p.saga_quantity - IFNULL(qi.total_reserved_quantity, 0),
  vii.reception = 1,
  p.saga_quantity = vii.quantity - IFNULL(qi.total_reserved_quantity, 0),
  vi.closed_invoice = 1,
  vi.closed_date = NOW()
WHERE
  vi.id = '.$_POST['vendor_invoice_id'].';
';

	$projectsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);

echo  json_decode($projectsQuery);

	$QueryBuilder->closeConnection();


?>