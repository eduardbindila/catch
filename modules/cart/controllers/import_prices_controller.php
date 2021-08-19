<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

$manufacturerQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => 'products' ,
			"columns" => "Distinct manufacturer"
		)
	);

var_dump($manufacturerQuery);


include($_MPATH['CART_VIEWS'].'import_prices_view.php');

?>