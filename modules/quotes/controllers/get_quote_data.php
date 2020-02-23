<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$quoteQuery = $QueryBuilder->selectQuoteData();

	echo json_encode(utf8ize($quoteQuery));

	$QueryBuilder->closeConnection();
?>