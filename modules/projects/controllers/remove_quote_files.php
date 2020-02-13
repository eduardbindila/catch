<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->delete(
		$conn,
		$options = array(
			"table" => "quote_files",
			"column" => "file_path",
			"in" => $_POST['file_path'],
			"and" => "quote_id = '".$_POST['quote_id']."'"
		)
	);
	

	if ($query)
    {
        header('Content-Type: application/json');
        print json_encode($query);
    }
else
    {
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }

	$QueryBuilder->closeConnection();


?>