<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


// $query = "select 
// 			q.id as quote_id, 
// 			q.name as quote_name, 
// 			q.quote_price as quote_value,
// 			qs.name as quote_status, 
// 			q.quote_status as quote_status_id, 
// 			q.start_date,
// 			u.name as owner,
// 			c.name as client_name,
// 			qid.total_quote_items,
// 			qid.total_orders_sent,
// 			qid.total_quote_items_reserved,
// 			(
// 				case
// 					when qid.total_quote_items <= (qid.total_orders_sent + qid.total_quote_items_reserved)
// 						then 100
// 					when 
// 						qid.total_quote_items > (qid.total_orders_sent + qid.total_quote_items_reserved) 
// 						and 
// 						(qid.total_orders_sent + qid.total_quote_items_reserved) > 0 
// 						then 1
// 					when 
// 						(qid.total_orders_sent + qid.total_quote_items_reserved) = 0 
// 						then 0
// 				end
// 			) as supplier_order_sent_ratio,
// 			qid.total_quote_reserved_quantity,
// 			qid.total_quote_invoiced_quantity,
// 			(
// 				case
// 					when total_quote_reserved_quantity <= total_quote_invoiced_quantity and quote_status  = 11
// 						then 100
// 					when 
// 						total_quote_reserved_quantity > total_quote_invoiced_quantity 
// 						and 
// 						total_quote_invoiced_quantity > 0 
// 						then 1
// 					when 
// 						total_quote_invoiced_quantity = 0 
// 						then 0
// 				end
// 			) as quote_invoiced_ratio
// 		from quotes q 
// 		join quote_status qs on qs.id = q.quote_status
// 		join users u on q.assignee_id = u.id
// 		join clients c on q.client_id = c.id
// 		join (
// 			select 
// 			count(qi.id) as total_quote_items, 
// 			count(
// 				if((qi.order_number is not null), 1, null)
// 			) as total_orders_sent,
// 			count(
// 				if((qi.quantity = qi.reserved_stock), 1, null)
// 			) as total_quote_items_reserved,
// 			sum(qi.reserved_stock) as total_quote_reserved_quantity,
// 			sum(qi.invoiced_quantity) as total_quote_invoiced_quantity,
// 			qi.quote_id 
// 			from quote_items qi
// 			group by qi.quote_id 
// 		) qid on q.id = qid.quote_id
// 		where q.quote_status in (5,2,10,11)";

//echo $query;



		$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quotes q",
			"columns" => "
			q.id as quote_id, 
			q.name as quote_name, 
			q.quote_price as quote_value,
			qs.name as quote_status, 
			q.quote_status as quote_status_id, 
			q.start_date,
			u.name as owner,
			c.name as client_name,
			qid.total_quote_items,
			qid.total_orders_sent,
			qid.total_quote_items_reserved,
			(
				case
					when qid.total_quote_items <= (qid.total_orders_sent + qid.total_quote_items_reserved)
						then 100
					when 
						qid.total_quote_items > (qid.total_orders_sent + qid.total_quote_items_reserved) 
						and 
						(qid.total_orders_sent + qid.total_quote_items_reserved) > 0 
						then 1
					when 
						(qid.total_orders_sent + qid.total_quote_items_reserved) = 0 
						then 0
				end
			) as supplier_order_sent_ratio,
			qid.total_ordered_quantity,
			qid.total_quote_delivered_quantity,
			(
				case
					when total_ordered_quantity <= total_quote_delivered_quantity
						then 100
					when 
						total_ordered_quantity > total_quote_delivered_quantity 
						and 
						total_quote_delivered_quantity > 0 
						then 1
					when 
						total_quote_delivered_quantity = 0 
						then 0
				end
			) as quote_delivered_ratio,
			qid.total_quote_reserved_quantity,
			qid.total_quote_invoiced_quantity,
			(
				case
					when total_quote_reserved_quantity <= total_quote_invoiced_quantity
						then 100
					when 
						total_quote_reserved_quantity > total_quote_invoiced_quantity 
						and 
						total_quote_invoiced_quantity > 0 
						then 1
					when 
						total_quote_invoiced_quantity = 0 
						then 0
				end
			) as quote_invoiced_ratio

			",
			"innerJoin" => "
				quote_status qs on qs.id = q.quote_status
			join users u on q.assignee_id = u.id
			join clients c on q.client_id = c.id
			join (
				select 
				count(qi.id) as total_quote_items, 
				count(
					if((qi.order_number is not null), 1, null)
				) as total_orders_sent,
				count(
					if((qi.quantity = qi.reserved_stock), 1, null)
				) as total_quote_items_reserved,
				sum(qi.reserved_stock) as total_quote_reserved_quantity,
				sum(qi.invoiced_quantity) as total_quote_invoiced_quantity,
				sum(ifnull(qi.ordered_quantity, 0)) as total_ordered_quantity,
				SUM(case when vii.reception  = 1 then ifnull(vii.delivered_quantity, 0)  else 0 end) as total_quote_delivered_quantity,
				qi.quote_id 
				from quote_items qi
				join vendor_invoice_items_split viis on viis.quote_item_id = qi.id
				join vendor_invoice_items vii on vii.id = viis.vendor_invoice_item_id 
				group by qi.quote_id 
			) qid on q.id = qid.quote_id
			",
			"where" => "q.quote_status in (5,2,10,11)"
		)
	);

	// $projectsQuery = $QueryBuilder->customQuery(
	// 	$conn,
	// 	$query = $query
	// );


// printError($valuesArray);
  		echo$conn->error;


echo  json_encode($projectsQuery);

	$QueryBuilder->closeConnection();


?>