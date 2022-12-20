<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

$vat = $_POST['country'] == 'RO' ? 0.19 : 0;

$exchange_rate = floatVal($_POST['exchange_rate']); 

$value = 'TRUNCATE((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		package_items.package_quantity * package_items.external_item_unit_price
	        ELSE
	         package_items.package_quantity * quote_items.unit_price
	        END
   	 ) * '.$exchange_rate. '), 2)'; 

$unit_price = 'TRUNCATE((quote_items.unit_price * '.$exchange_rate. '), 2)';


$green_tax = "( 
		CASE 
	        	WHEN 
	        		green_tax.value is NULL
	       		THEN  
	        		0
	        ELSE
	         package_items.package_quantity * green_tax.value
	        END
   	 )";

$green_tax_value = $exchange_rate == 1 ?  0 : $green_tax;

$vatValue = 'TRUNCATE((('.$value.' + '.$green_tax_value. ') *  '.$vat .'), 2)';

$total = "(".$value.' + '.$vatValue.' + '.$green_tax_value.")";

$extra_discount_value = "TRUNCATE (".$total." * quotes.extra_discount / 100, 2)";

$total = $total.'-'.$extra_discount_value;



	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "package_items",
				"columns" => "package_items.*, products.id as product_id, products.product_name, products.saga_quantity, quote_items.reserved_stock, quote_items.quantity, quote_items.discount, quotes.extra_discount, ".$extra_discount_value." as extra_discount_value, quote_items.invoiced_quantity, quote_items.quote_id, ".$unit_price." as unit_price, ".$value." as value, ".$vatValue." as vat_value, ". $green_tax_value." as green_tax_value, ".$total." as total",
				"leftJoin" => 'quote_items on package_items.quote_item_id = quote_items.id 
						left join products on quote_items.product_id = products.id 
						left join green_tax on products.green_tax_id = green_tax.id
						left join quotes on quote_items.quote_id = quotes.id',
				"where" => "package_id = '".$_POST['package_id']."'",
				"orderBy" => 'package_items.id',
				"orderType" => 'ASC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>