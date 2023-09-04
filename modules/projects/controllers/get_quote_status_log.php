<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);


	$query = "SELECT qsl.id, quote_id, date,u.name as user_name, qs.name as status_name from quote_status_log qsl
	INNER JOIN users u on  qsl.user_id = u.id
	INNER JOIN quote_status qs on  qsl.status_id = qs.id
	WHERE quote_id = '".$_POST['quote_id']."'";


	$description = $QueryBuilder->customQuery(
            $conn,
            $query = $query
        );

	echo json_encode($description);

	$QueryBuilder->closeConnection();
?>