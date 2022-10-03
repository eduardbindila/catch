<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);

$ids = [];

$whens = '';


foreach ($_POST['quoteItems'] as $key => $value) {

	array_push($ids, $key);
	$whens = $whens.' when '.$key.' then GREATEST(qi.quantity - qi.ordered_quantity, 0)' ;

}


$query = "update quote_items qi, products p, vendor_invoice_items vii
			SET qi.reserved_stock = case qi.id 
									".$whens."
									end,
				p.saga_quantity = case p.id 
			    				when '".$_POST['product']."' then ".$_POST['newStock']."
			                    end,
				vii.reception = case vii.id 
			    				when ".$_POST['itemId']." then 0
			                    end,
			    vii.remaining_stock = case vii.id 
			    				when ".$_POST['itemId']." then 0
			                    end
			where qi.id in (".implode(",",$ids).") and p.id in ('".$_POST['product']."') and vii.id in (".$_POST['itemId'].")";


	$projectsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);


// printError($valuesArray);
  		echo$conn->error;


echo  json_decode($projectsQuery);

	$QueryBuilder->closeConnection();


?>