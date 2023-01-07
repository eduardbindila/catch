<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

$vat = $_POST['country'] == 'RO' ? 0.19 : 0;

$exchange_rate = floatVal($_POST['exchange_rate']); 


$unit_price = 'TRUNCATE((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		package_items.external_item_unit_price
	        ELSE
	         quote_items.unit_price - (quotes.extra_discount *quote_items.unit_price / 100)
	        END
   	 ) * '.$exchange_rate. '), 2)';


$unit_price_before_discount = 'TRUNCATE((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		package_items.external_item_unit_price
	        ELSE
	         quote_items.unit_price
	        END
   	 ) * '.$exchange_rate. '), 2)';



$extra_discount_value = 'TRUNCATE((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		0
	        ELSE
	         quotes.extra_discount *quote_items.unit_price / 100
	        END
   	 ) * '.$exchange_rate. '), 2)';



$value = 'TRUNCATE((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		package_items.package_quantity * package_items.external_item_unit_price
	        ELSE
	         package_items.package_quantity * '.$unit_price.'
	        END
   	 ) * '.$exchange_rate. '), 2)';

$green_tax_id = 'CASE 
        	WHEN 
        		package_items.quote_item_id is NULL
       		THEN  
        		package_items.external_item_green_tax_id
        ELSE
         products.green_tax_id
        END';


 $green_tax_value = 'CASE 
        	WHEN 
        		package_items.quote_item_id is NULL
       		THEN  
        		external_green_tax.value
        ELSE
         green_tax.value
        END';


$green_tax_total = "( 
		CASE 
	        	WHEN 
	        		".$green_tax_value." is NULL
	       		THEN  
	        		0
	        ELSE
	         package_items.package_quantity * ".$green_tax_value."
	        END
   	 )";


$green_tax_value = $exchange_rate == 1 ?  0 : $green_tax_value;

$green_tax_total = $exchange_rate == 1 ?  0 : $green_tax_total;

$green_tax_value = $green_tax_total ? 0 : $green_tax_value;

$vatValue = 'TRUNCATE(('.$value.' *  '.$vat .'), 2)';

$total = "(".$value." + ".$vatValue." )";



	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "package_items",
				"columns" => "package_items.*, 
							products.id as product_id, 
							products.product_name, 
							products.saga_quantity, 
							quote_items.reserved_stock, 
							quote_items.quantity, 
							quote_items.discount, 
							quotes.extra_discount, 
							quote_items.invoiced_quantity, 
							quote_items.quote_id,
							green_tax.value as green_tax,
							external_green_tax.value as external_green_tax,
							package_item_types.name as type_name,
							".$value." as value, 
							".$unit_price." as unit_price, 
							".$unit_price_before_discount." as unit_price_before_discount, 
							".$extra_discount_value." as extra_discount_value, 
							".$vatValue." as vat_value, 
							". $green_tax_id." as green_tax_id,
							".$green_tax_value." as green_tax_value,
							".$green_tax_total." as green_tax_total,
							".$total." as total",


				"leftJoin" => 'quote_items on package_items.quote_item_id = quote_items.id 
						left join products on quote_items.product_id = products.id 
						left join green_tax on products.green_tax_id = green_tax.id
						left join green_tax as external_green_tax on package_items.external_item_green_tax_id = external_green_tax.id
						left join quotes on quote_items.quote_id = quotes.id
						join package_item_types on package_items.type = package_item_types.id',
				"where" => "package_id = '".$_POST['package_id']."'",
				"orderBy" => 'package_items.id',
				"orderType" => 'ASC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>