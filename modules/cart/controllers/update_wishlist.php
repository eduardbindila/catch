<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$newWishlist = json_decode($_POST['existingWishlist']);

	array_push($newWishlist, $_POST['productId']);

	//echo json_encode($newWishlist);


	$updateWishlist = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "users",
			"set" => ["`wishlist`='".json_encode($newWishlist)."'"],
			"where" => "id = ".$_SESSION['user_id']
		)
	);

	echo json_encode($updateWishlist);

	$QueryBuilder->closeConnection();

?>