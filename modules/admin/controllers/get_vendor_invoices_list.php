<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	// $projectsQuery = $QueryBuilder->select(
	// 	$conn,
	// 	$options = array(
	// 		"table" => "vendor_invoices",
	// 		"columns" => "*",
	// 		"orderBy" => 'invoice_no',
	// 		"orderType" => "ASC"
	// 	)
	// );

	$query = "select vi.*, sis.name as saga_status from vendor_invoices vi 
   join vendors v on v.id = vi.vendor 
   left JOIN 
    saga_imported_invoices sii ON sii.invoice_id = 
    vi.invoice_no  and sii.type = 'intrari'
left join saga_import_details sid on sid.saga_process_id = sii.process_id and sid.request_type_id = 5
left join saga_import_status sis on sis.id = sid.status order by vi.id desc";

	 // Use your custom query builder to execute the query
    $vquery = $QueryBuilder->customQuery(
        $conn,
        $query
    );

	echo json_encode(utf8ize($vquery));

	$QueryBuilder->closeConnection();
?>


