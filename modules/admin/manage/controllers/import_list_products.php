<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_POST);

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer

$when = '';

$ids = '';

$i = 0;

$valuesArray = [];

function fixProductId($product_id)
{
	if(is_numeric($product_id) && strlen($product_id) < 7 )
	{
		$zeros = str_repeat("0", 7 - strlen($product_id));

		return $zeros.''.$product_id;

	} else {
		return $product_id;
	}
}

while(! feof($f_pointer)){
	$product=fgetcsv($f_pointer);


	$localArray = array(
			'import_product_list_id' => "",
			'product' => "",
			'product_name' => "",
			'initial_price' => "0.00",
			'manufacturer' => "",
			'new_product_id' => "",
			'status' => $_POST['status'] == '6' ? 7 : 1
		);


	if($_POST['status'] == '6') {

		$product_id = addslashes(trim($product[0]));

		$new_product_id = addslashes(trim($product[4]));

		$localArray['import_product_list_id'] = $_POST['import_product_list_id'];
		$localArray['product'] = fixProductId($product_id);
		$localArray['new_product_id'] = $new_product_id;

	} else if(($product[0] && $product[1] && $product[2]) || ($product[0]) && $product[4]) {
		$product_id = addslashes(trim($product[0]));

		$product_name = substr(str_replace("'", "", str_replace('"', "", htmlentities($product[1], ENT_IGNORE))), 0, 253).'...';

		$initial_price = number_format((float)trim($product[2]), 2, '.', '');

		//var_dump($initial_price);

		$manufacturer = preg_replace("/[^a-zA-Z 0-9]+/", "",   trim(substr($product[3], 0, 3)));


		//var_dump(htmlentities($product[1], ENT_IGNORE));


		// $localArray = array(
		// 	'import_product_list_id' => $_POST['import_product_list_id'],
		// 	'product' => fixProductId($product_id),
		// 	'product_name' => $product_name,
		// 	'initial_price' =>$initial_price,
		// 	'manufacturer' => $manufacturer,
		// 	'new_product_id' => ''
		// );

		$localArray['import_product_list_id'] = $_POST['import_product_list_id'];
		$localArray['product'] = fixProductId($product_id);
		$localArray['product_name'] = $product_name;
		$localArray['new_product_id'] = '';

		$localArray['initial_price'] = $initial_price;
		$localArray['manufacturer'] = $manufacturer;
		
		//var_dump($localArray);
		
	}	

	array_push($valuesArray, $localArray);
}


//var_dump($valuesArray);


$conn = $QueryBuilder->dbConnection();

	$productQuery = $QueryBuilder->insert(
            $conn,
            $options = array(
                "table" => "products_import",
                "keys" => ["import_product_list_id", "product_id", "name", "price", "manufacturer", "new_product_id", "status"],
                "values" => $valuesArray,
            ),
            $multi = true
            
        );

	$affectedRows = $conn->affected_rows;

	if($affectedRows > 0) {
		echo json_encode($affectedRows);
	} else {
		echo json_encode(0);
	}
//var_dump($conn->error);

	
	
$QueryBuilder->closeConnection();


// var_dump($_POST);

?>