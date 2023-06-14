<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

$vat = $_POST['country'] == 'RO' ? 0.19 : 0;

$green_tax_value_field = $_POST['invoice_date'] > '2023-02-28' ? "value_2023" : "value";

if($_POST['isRon'] == 1) {
	$exchange_rate = 1;
} else{
	if($_POST['country'] !== 'RO') {
		$exchange_rate =  1;
	} else {
		$exchange_rate =  floatVal($_POST['exchange_rate']);
	}	
}

if($_POST['country'] == 'RO') {
	$external_exchange_rate = 1;
}
else {
	$external_exchange_rate = $exchange_rate;
}

$unit_price = 'Round((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		package_items.external_item_unit_price * '.$external_exchange_rate.'
	        ELSE
	         (quote_items.unit_price - (quotes.extra_discount *quote_items.unit_price / 100) ) * '.$exchange_rate. '
	        END
   	 ) ), 2)';


$unit_price_before_discount = 'Round((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		package_items.external_item_unit_price * '.$external_exchange_rate.'
	        ELSE
	         quote_items.unit_price * '.$exchange_rate. '
	        END
   	 )), 2)';



$extra_discount_value = 'Round((
	(
	        CASE 
	        	WHEN 
	        		package_items.quote_item_id is NULL
	       		THEN  
	        		0
	        ELSE
	         quotes.extra_discount * quote_items.unit_price / 100 * package_items.package_quantity 
	        END
   	 ) * '.$exchange_rate. '), 2)';



$value_before_discount = 'Round((
	(
	         package_items.package_quantity * '.$unit_price_before_discount.'
   	 )), 2)';


  $value = 'Round((
	(
	         package_items.package_quantity * '.$unit_price.'
   	 )), 2)';

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
        		external_green_tax.'.$green_tax_value_field.'
        ELSE
         green_tax.'.$green_tax_value_field.'
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


$green_tax_value = $_POST['country'] == 'RO' ?  $green_tax_value : 0;

$green_tax_total = $_POST['country'] == 'RO' ?  $green_tax_total : 0;

//$green_tax_value = $green_tax_total ? 0 : $green_tax_value;

$vatValue = 'Round(('.$value.' *  '.$vat .'), 2)';

$vatValue_before_discount = 'Round(('.$value_before_discount.' *  '.$vat .'), 2)';

$total = "(".$value." + ".$vatValue." )";

$total_before_discount = "(".$value_before_discount." + ".$vatValue_before_discount." )";

if($_POST['consolidate'] == 1) {
	$collect_groupby = " group by products.id "; 
	$collect_sum = "sum(package_items.package_quantity) as package_quantity,";
}
else {
	$collect_groupby = "";
	$collect_sum = "";
}

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "package_items",
				"columns" => "package_items.*, 
							products.id as product_id, 
							products.isService, 
							CONCAT_WS(CHAR(13), products.product_name, package_items.item_details) AS product_name,
							products.saga_quantity, 
							quote_items.reserved_stock, 
							quote_items.quantity, 
							quote_items.discount, 
							quotes.extra_discount, 
							quote_items.invoiced_quantity, 
							quote_items.quote_id,
							package_item_types.name as type_name,
							".$collect_sum."
							".$value." as value, 
							".$value_before_discount." as value_before_discount,
							".$unit_price." as unit_price, 
							".$unit_price_before_discount." as unit_price_before_discount, 
							".$extra_discount_value." as extra_discount_value, 
							".$vatValue." as vat_value,
							".$vatValue_before_discount." as vat_value_before_discount,  
							".$green_tax_id." as green_tax_id,
							".$green_tax_value." as green_tax_value,
							".$green_tax_total." as green_tax_total,
							".$total_before_discount." as total_before_discount,
							".$total." as total",


				"leftJoin" => 'quote_items on package_items.quote_item_id = quote_items.id 
						left join products on quote_items.product_id = products.id 
						left join green_tax on products.green_tax_id = green_tax.id
						left join green_tax as external_green_tax on package_items.external_item_green_tax_id = external_green_tax.id
						left join quotes on quote_items.quote_id = quotes.id
						join package_item_types on package_items.type = package_item_types.id',
				"where" => "package_id = '".$_POST['package_id']."' ".$collect_groupby ,
				"orderBy" => 'package_items.id',
				"orderType" => 'ASC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>

