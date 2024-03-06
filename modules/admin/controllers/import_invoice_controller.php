<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


	$query = "
select
	sid.status as status_id, sis.name, sid.id as request_id, sid.response_notification as notification_id
from
	saga_imported_invoices si
join saga_import_processess sip on si.process_id = sip.id 
join saga_import_details sid on sid.saga_process_id = sip.id and sid.request_type_id = '".$invoiceGET['typeNo']."'
join saga_import_status sis on sis.id = sid.status 
where
	type = '".$invoiceGET['typeName']."' and invoice_id ='".$invoiceGET['invoice']."' and code = '".$invoiceGET['code']."'";


	 // Use your custom query builder to execute the query
    $statusQuery = $QueryBuilder->customQuery(
        $conn,
        $query
    );

// echo $query;

//printError($statusQuery);

$importStatus = '';

$generateDisabled = "disabled";

$sendDisabled = "disabled";

$checkDisabled = "disabled";


$requestId = isset($statusQuery[0]['request_id']) ? $statusQuery[0]['request_id'] : 0;

$notificationId = isset($statusQuery[0]['notification_id']) ? $statusQuery[0]['notification_id'] : 0;

if(isset($statusQuery[0]['status_id'])) {
	switch ($statusQuery[0]['status_id']) {
	  case 5:
	  	$importStatus = 'Saga Format Generated';
	  	$sendDisabled = '';

	    break;
	  case 1:
	    $importStatus = 'Sent to Saga';
	    $checkDisabled = '';
	    break;
	  case 2:
	   	$importStatus = 'Succesfuly Received by Saga';
	    break;
	  case 3:
	   	$importStatus = 'Received with Error by Saga';
	    break;
	  default:
	    $importStatus = 'Import not started';
	    $generateDisabled = '';
	}
} else {
	$importStatus = 'Import not started';
	    $generateDisabled = '';
}



$LoadHTMLArtefacts->setScript($_WMPATH['ADMIN_VIEWS'].'import-invoice.js');

include($_MPATH['ADMIN_VIEWS'].'import_invoice_view.php');

?>