<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$updateWishlist = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "users",
			"columns" => "wishlist",
			"where" => "id = ".$_SESSION['user_id']
		)
	);

	echo json_encode($updateWishlist[0]['wishlist']);

	$QueryBuilder->closeConnection();

?>