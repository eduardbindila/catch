<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

		$query = "
	select
		sid.status as status_id, sis.name, sid.request_id, sid.notification_id, sip.id as process_id
	from
		saga_imported_invoices si
	join saga_import_processess sip on si.process_id = sip.id 
	JOIN
    (
        SELECT 
            saga_process_id,
            status,
            id AS request_id,
            response_notification AS notification_id,
            ROW_NUMBER() OVER (PARTITION BY saga_process_id ORDER BY id DESC) AS rn
        FROM 
            saga_import_details
        WHERE 
            request_type_id = '".$invoiceGET['typeNo']."'
    ) sid ON sid.saga_process_id = sip.id AND sid.rn = 1
	join saga_import_status sis on sis.id = sid.status 
	where
		type = '".$invoiceGET['typeNo']."' and invoice_id ='".$invoiceGET['invoice']."'";


		 // Use your custom query builder to execute the query
	    $statusQuery = $QueryBuilder->customQuery(
	        $conn,
	        $query
	    );

	    //echo $query;



//printError($statusQuery);


	$requestId = isset($statusQuery[0]['request_id']) ? $statusQuery[0]['request_id'] : 0;

	$processId = isset($statusQuery[0]['process_id']) ? $statusQuery[0]['process_id'] : 0;

	$notificationId = isset($statusQuery[0]['notification_id']) ? $statusQuery[0]['notification_id'] : 0;

		
$LoadHTMLArtefacts->setScript($_WMPATH['ADMIN_VIEWS'].'import-invoice.js');

include($_MPATH['ADMIN_VIEWS'].'import_invoice_view.php');

?>