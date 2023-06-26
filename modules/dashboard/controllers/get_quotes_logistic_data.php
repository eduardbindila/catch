<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


$query = "SELECT sub.quote_id, sub.quote_name, sub.quote_status, sub.owner, sub.client_name, sub.quote_item_id, sub.product_id, sub.quantity, sub.reserved_stock, sub.ordered_quantity,
       sub.in_transit_quantity, sub.received_quantity, sub.invoiced_quantity, sub.date_added,
       CASE
           WHEN (sub.in_transit_quantity = 0)
                AND (sub.received_quantity = 0)
                AND (sub.invoiced_quantity = 0) THEN
               CASE
                   WHEN (sub.quantity > sub.reserved_stock + sub.ordered_quantity) THEN 'yellow'
                   WHEN (sub.reserved_stock + sub.ordered_quantity) = 0 THEN 'red'
                   ELSE 'green'
               END
           ELSE 'green'
       END AS quote_fullfilled_color,
       CASE
           WHEN (sub.in_transit_quantity = 0)
                AND (sub.received_quantity = 0)
                AND (sub.invoiced_quantity = 0) THEN
               CASE
                   WHEN sub.quantity = 0 THEN '100'
                   WHEN sub.quantity > 0 THEN
                       CASE
                           WHEN ((sub.reserved_stock + sub.ordered_quantity) / sub.quantity * 100) > 100 THEN '100'
                           ELSE FORMAT((sub.reserved_stock + sub.ordered_quantity) / sub.quantity * 100, '0.00') + '%'
                       END
               END
           ELSE '100'
       END AS quote_fullfilled_ratio,
       CASE
           WHEN (sub.received_quantity = 0)
                AND (sub.invoiced_quantity = 0) THEN
               CASE
                   WHEN sub.in_transit_quantity > 1 THEN 'blue'
                   WHEN sub.in_transit_quantity = 0 THEN 'red'
                   ELSE 'green'
               END
           ELSE 'green'
       END AS order_in_intransit_color,
       CASE
           WHEN (sub.received_quantity = 0)
                AND (sub.invoiced_quantity = 0) THEN
               CASE
                   WHEN sub.in_transit_quantity = 0 THEN '0'
                   WHEN sub.in_transit_quantity > 0 THEN
                       CASE
                           WHEN (sub.in_transit_quantity / sub.ordered_quantity * 100) > 100 THEN '100'
                           ELSE FORMAT(sub.in_transit_quantity, 0 / sub.ordered_quantity * 100, '0.00') + '%'
                       END
               END
           ELSE '100'
       END AS order_in_transit_ratio,
       CASE
           WHEN sub.invoiced_quantity = 0 THEN
               CASE
                   WHEN sub.received_quantity > 0 AND sub.received_quantity != sub.ordered_quantity THEN 'yellow'
                   WHEN sub.received_quantity = 0 THEN 'red'
                   WHEN sub.received_quantity <= sub.ordered_quantity THEN 'green'
               END
           ELSE 'green'
       END AS received_order_color,
       CASE
           WHEN sub.invoiced_quantity = 0 THEN 'red'
           WHEN sub.invoiced_quantity > 1 AND sub.invoiced_quantity != sub.quantity THEN 'yellow'
           WHEN sub.invoiced_quantity <= sub.quantity THEN 'green'
       END AS invoiced_order_color,
       CASE
           WHEN sub.invoiced_quantity = 0 THEN
               CASE
		           WHEN sub.received_quantity = 0 THEN '0'
		           WHEN sub.received_quantity > 0 THEN
		               CASE
		                   WHEN (sub.received_quantity / sub.ordered_quantity * 100) > 100 THEN '100'
		                   ELSE FORMAT(sub.received_quantity / sub.ordered_quantity * 100, '0.00') + '%'
		               END
		        END
		    ELSE '100'
       END AS received_order_ratio,
       CASE
           WHEN sub.invoiced_quantity = 0 && sub.quantity > 0 THEN '0'
           WHEN sub.invoiced_quantity = 0 && sub.quantity = 0 THEN '100'
           WHEN sub.invoiced_quantity > 0 THEN
               CASE
                   WHEN (sub.invoiced_quantity / sub.quantity * 100) > 100 THEN '100'
                   ELSE FORMAT(sub.invoiced_quantity / sub.quantity * 100, '0.00') + '%'
               END
       END AS invoiced_order_ratio
FROM (
    SELECT q.id AS quote_id, q.name as quote_name, qs.name as quote_status, c.name as client_name, u.name as owner, qi.id AS quote_item_id, qi.product_id, COALESCE(qi.quantity, 0) as quantity, COALESCE(qi.reserved_stock, 0) as reserved_stock, COALESCE(qi.ordered_quantity, 0) as ordered_quantity,
           SUM(CASE WHEN coalesce(vii.reception,0) = 0 THEN coalesce(viis.quantity, 0) ELSE 0 END) AS in_transit_quantity,
           SUM(CASE WHEN vii.reception = 1 THEN coalesce(viis.quantity, 0) ELSE 0 END) AS received_quantity,
           COALESCE(qi.invoiced_quantity, 0) as invoiced_quantity, vii.date_added
    FROM quote_items qi
    left JOIN vendor_invoice_items_split viis ON qi.id = viis.quote_item_id
    left JOIN vendor_invoice_items vii ON viis.vendor_invoice_item_id = vii.id
    left JOIN quotes q ON qi.quote_id = q.id
    JOIN clients c ON q.client_id = c.id
    JOIN users u ON c.user_id = u.id
    JOIN quote_status qs ON q.quote_status = qs.id
    WHERE q.quote_status IN (5, 2, 10, 11)
    GROUP BY qi.id, q.id
    ORDER BY q.id, vii.date_added
) AS sub;

";


	$projectsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);


// printError($valuesArray);
  		//echo$conn->error;


echo  json_encode($projectsQuery);

	$QueryBuilder->closeConnection();


?>