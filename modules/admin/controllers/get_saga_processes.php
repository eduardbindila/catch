<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => " saga_import_details sid ",
			"columns" => "	sid.saga_process_id,
							sis2.name as process_status,
							sip.start_time as process_start_time,
							srt.name as request_type, 
							request,
							sis.name as request_status,
							response_notification,
							response_error",
			"leftJoin" => ' saga_import_processess sip on sid.saga_process_id = sip.id 
							join saga_request_types srt on srt.id = request_type_id
							join saga_import_status sis on sis.id = sid.status 
							join saga_import_status sis2 on sis2.id = sip.overall_status',
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>