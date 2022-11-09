<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

$vat = $_POST['country'] == 'RO' ? 0.19 : 0 ; 

$value = '(
        CASE 
        	WHEN 
        		package_items.quote_item_id is NULL
       		THEN  
        		package_items.package_quantity * package_items.external_item_unit_price
        ELSE
         package_items.package_quantity * quote_items.unit_price
        END
    )';

$vatValue = 'TRUNCATE(('.$value.' * '.$vat. '), 2)';

$total = $value.' + '.$vatValue;



	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "package_items",
				"columns" => "package_items.*, products.id as product_id, products.product_name, products.saga_quantity, quote_items.reserved_stock, quote_items.quantity, quote_items.invoiced_quantity, quote_items.quote_id, quote_items.unit_price, ".$value." as value, ".$vatValue." as vat_value, ".$total." as total",
				"leftJoin" => 'quote_items on package_items.quote_item_id = quote_items.id left join products on quote_items.product_id = products.id',
				"where" => "package_id = '".$_POST['package_id']."'",
				"orderBy" => 'package_items.id',
				"orderType" => 'ASC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>