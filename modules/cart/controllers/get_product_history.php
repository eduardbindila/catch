<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//echo $_POST['product_id'];


$conn = $QueryBuilder->dbConnection();

	$query ="
	SELECT
  sub.*,
  SUM(sub.units) OVER (PARTITION BY sub.product_id ORDER BY sub.date, sub.document_type, sub.sub_id) AS intermediate_stock
  FROM
(
  SELECT
    sub_inner.*
  FROM
  (
    SELECT
      vii.product_id,
      CASE
      WHEN vi.date = '0000-00-00' OR vi.date IS NULL OR vi.date NOT REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' THEN '1970-01-01'
      ELSE vi.date
    END AS date,
      vi.invoice_no as document_number,
      'vendor_invoice' as document_type,
      vii.vendor_invoice_id as id,
      vii.id as sub_id,
      CASE
        WHEN vi.inventory = 1 THEN vii.delivered_quantity
        ELSE vii.quantity
      END AS units,
      vii.unit_price AS unit_price,
      vii.total_price AS total_value
    FROM
      vendor_invoice_items vii
    LEFT JOIN vendor_invoices vi ON vii.vendor_invoice_id = vi.id
    where YEAR(vi.date) = ".$_POST['year']."
    UNION ALL
    SELECT
      qi.product_id,
      p.invoice_date AS date,
      p.invoice_number as document_number,
      'client_invoice' as document_type,
      p.quote_id as id,
      p.id as sub_id,
      -pi2.package_quantity AS units,
      qi.unit_price AS unit_price,
      qi.unit_price * pi2.package_quantity AS total_value
    FROM
      package_items pi2
    JOIN quote_items qi ON pi2.quote_item_id = qi.id
    JOIN packages p ON pi2.package_id = p.id
    WHERE
      p.package_status_id = 4 and  YEAR(p.invoice_date) = ".$_POST['year']."
  ) AS sub_inner
) AS sub
WHERE sub.product_id = '".$_POST['product_id']."'
ORDER BY
  sub.date, sub.document_type, sub.sub_id;
";


    // Use your custom query builder to execute the query
    $projectsQuery = $QueryBuilder->customQuery(
        $conn,
        $query
    );


	//printError($query);

	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();


?>

