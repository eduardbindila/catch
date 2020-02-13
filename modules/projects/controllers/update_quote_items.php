<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

if(isset($_POST['update_description'])) {

	$projectsQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "quote_items",
				"set" => ["`customer_description`='".addslashes($_POST['data']['description'])."'","`destination`='".addslashes($_POST['data']['destination'])."'","`criteria`='".$_POST['data']['index']."'"],
				"where" => "`id` = ".$_POST['quote_item_id']
			)
		);

	if($projectsQuery)
		echo true;

} else {
	foreach ($_POST['products'] as $key => $product) {
		# code...
	

		$projectsQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "quote_items",
				"set" => ["`quote_item_status`=".$_POST['quote_item_status']."","`rejection_reason`=".$_POST['rejection_reason'].""],
				"where" => "`quote_id` = ".$_POST['quote_id']." AND `product_id` = '".$product."';"
			)
		);

	}

	echo true;
}

	

	$QueryBuilder->closeConnection();
?>