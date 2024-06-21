<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	$valuesArray = [];

	//var_dump($_POST);

	$conn = $QueryBuilder->dbConnection();




		
	 //var_dump($valuesArray);


$quoteItemsQuery = "
select qi.id as quote_item_id, qi.unit_price, p.green_tax_id from quote_items qi
join quotes q on q.id = qi.quote_id 
join clients c on c.id = q.client_id 
join products p on p.id = qi.product_id 
where qi.id in (".implode(",",$_POST['quote_items']).")";


//echo $quoteItemsQuery;

$quoteItemsData = $QueryBuilder->customQuery(
        $conn,
        $quoteItemsQuery
    );


foreach ($quoteItemsData as $key => $value) {
			$localArray = array(
				'quote_item_id' => $value['quote_item_id'],
				'unit_price' => $value['unit_price'],
				'green_tax_id' => isset($value['green_tax_id'])  ? $value['green_tax_id'] : 0,
				'package_id' => $_POST['package_id'],
			);

			array_push($valuesArray, $localArray);
		}



	
	//printError($valuesArray);


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "package_items",
			"keys" => ["quote_item_id", "unit_price", "green_tax_id", "package_id"],
			"values" => $valuesArray
		),
		$multi = true
	);


printError($valuesArray);
		echo$conn->error;


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>