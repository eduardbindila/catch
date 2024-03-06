<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

$query = "SELECT 
    p.id, 
    quote_id, 
    invoice_number, 
    invoice_date, 
    invoice_due_date, 
    c.name, 
    c.saga_code,
    sis.name as status_name
FROM 
    packages p
JOIN 
    quotes q ON q.id = p.quote_id 
JOIN 
    clients c ON c.id = q.client_id
left JOIN 
    saga_imported_invoices sii ON sii.invoice_id = 
    CASE 
        WHEN c.country = 'ro' THEN CONCAT('ron-', invoice_number)
        ELSE CONCAT('ext-', invoice_number) and sii.code = c.saga_code and sii.type = 4
    end
left join saga_import_details sid on sid.saga_process_id = sii.process_id and sid.request_type_id = 4
left join saga_import_status sis on sis.id = sid.status 
WHERE 
    package_status_id = 4
ORDER BY 
    p.id DESC;
";



	 // Use your custom query builder to execute the query
    $query = $QueryBuilder->customQuery(
        $conn,
        $query
    );


	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>

