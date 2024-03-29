<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');



$projectID = basename($urlArray['path']);

//echo $_pageName; 1574978400/1431 / MTU3NDk3ODQwMC8xNDMx
// echo $_pageName.'wer';


if($_pageName == 'offer') {

	if(isset($_GET['hash'])) {
		$hash = $_GET['hash'];

		$hashArray = explode("/",base64_decode($hash));
		if(isset($hashArray[1])) {
			$projectID = $hashArray[1];

			//echo $projectID;
		}
		else {
			$hashArray = 0;
		}
	}	
}

$conn = $QueryBuilder->dbConnection();

	$rejectionQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "rejection_reason",
			"columns" => "*",
		),
		$returnType = "idAsArray"
	);

	$quoteItemStatusQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_item_status",
			"columns" => "*",
		),
		$returnType = "idAsArray"
	);


	//var_dump($quoteItemStatusQuery);

	if($_pageName == 'quote'|| $_pageName == 'offer') {
		$quoteQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quotes",
				"columns" => "*",
				"where" => "id = '".$projectID."'"
			)
		);
	} else {

		$projectQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "projects",
				"columns" => "*",
				"where" => "id = '".$projectID."'"
			)
		);

		$projectQuery = isset($projectQuery[0]) ? $projectQuery[0] : $projectQuery ;

		// if($projectQuery['master_quote']) {
		// 	$masterQuote = $QueryBuilder->select(
		// 		$conn,
		// 		$options = array(
		// 			"table" => "quotes",
		// 			"columns" => "*",
		// 			"where" => "id = '".$projectQuery['master_quote']."'"
		// 		)
		// 	);

		// 	$masterQuote = $masterQuote[0];
		// }


		if($_clientView && isset($_SESSION['is_client'])) {
			$restrictIfClient = 'AND client_id = '.$_SESSION['is_client'];
		} else {
			$restrictIfClient = "";
		}


		$quoteQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quotes",
				"columns" => "*",
				"where" => "project_id = '".$projectID."' ".$restrictIfClient
			)
		);
	}

	//Delivered Revenue
	$projectRevenue = array(
		"project_profit" => 0,
		"project_revenue" => 0
	);


	$revenueByStatus = array(
		"4" => "0",
		"7" => "0",
		"3" => "0",
		"1" => "0",
		"5" => "0",
		"2" => "0",
		"8" => "0",
		"9" => "0",
		"10" => "0",
		"11" => "0",
		"12" => "0",
		"13" => "0",
	);

	foreach ($quoteQuery as $key => $quote) {

		
		# code...
		//var_dump($quote['id']);


		if($quote['quote_status'] == 2) {
			$projectRevenue['project_profit'] = $projectRevenue['project_profit'] + $quote['profit'];
			$projectRevenue['project_revenue'] = $projectRevenue['project_revenue'] + $quote['quote_price'];
		}

		if($quote['isMaster']) {

			$revenueByStatus[$quote['quote_status']] = $revenueByStatus[$quote['quote_status']] + $quote['quote_price'];
		};

		//var_dump($revenueByStatus);

		$quoteItemsQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_items",
				"columns" => "*",
				"where" => "quote_id = '".$quote['id']."'"
			)
		);

		$clientQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "clients",
				"columns" => "*",
				"where" => "id = '".$quote['client_id']."'"
			)
		);

		

		$quoteProducts = array(
			"data" => array()
		);

		foreach ($quoteItemsQuery as $quoteDetails => $quoteValues) {

				$quoteProductDetails = $QueryBuilder->select(
					$conn,
					$options = array(
						"table" => "products",
						"columns" => "id, product_name, product_image, initial_price, is_temporary, active, manufacturer, saga_quantity",
						"where" => "id = '".$quoteValues['product_id']."'"
					)
				);

							

			if($quoteProductDetails) {
				$quoteProducts['data'][$quoteDetails] = $quoteProductDetails[0];
			} 



			if (empty($quoteProductDetails))  {

                //echo $quoteValues['product_id'];


                showError('Quote ' . $quote['id']. '  -> Product' . $quoteValues['product_id'] . ' could not be found');

                continue;
			}

			//var_dump($quoteProductDetails);	

			
			$temporary_product = isset($quoteProductDetails[0]['is_temporary']) ? $quoteProductDetails[0]['is_temporary'] : 0;

			$list_price = intval($quoteValues['aquisition_price']) > 0 ?$Pricing->getListPrice($quoteValues['aquisition_price']) : $Pricing->getListPrice($quoteProductDetails[0]['initial_price']);
			$min_price = intval($quoteValues['aquisition_price']) > 0 ? $Pricing->getMinPrice($quoteValues['aquisition_price']) : $Pricing->getMinPrice($quoteProductDetails[0]['initial_price']);

			$db_unit_price = $quoteValues['unit_price'];

			$unit_price = $quoteValues['unit_price'] > 0 ? $quoteValues['unit_price'] : $list_price - ($quoteValues['discount'] ? ($list_price * $quoteValues['discount']/100) : 0);

			$unit_price = number_format((float)$unit_price, 2, '.', '');

			//update unit price if the unit price is 0 in the database
			if(intval($db_unit_price) == 0) {
				$quoteUpdate = $QueryBuilder->update(
					$conn,
					$options = array(
						"table" => "quote_items",
						"set" => ["`unit_price`=".$unit_price.""],
						"where" => "id = ".$quoteValues['id']
					)
				);


			}

			$profit =  $unit_price - $quoteProductDetails[0]['initial_price'];

			$profit =  number_format((float)$profit, 2, '.', '');

			if(($profit == 0) OR ($unit_price == 0)) {
				$profit_percent = 0;
			} else {
				$profit_percent = $profit * 100 / $unit_price ;

				$profit_percent = number_format((float)$profit_percent, 2, '.', '');

			}
			if($temporary_product && $quoteProductDetails[0]['product_image']) {

				$quoteProductDetails[0]['product_image'] = $host.'/uploads/'.$quoteProductDetails[0]['product_image'];
			}  
			if($_pageName == 'quote'|| $_pageName == 'offer') {

			} else {
				$quoteProducts['data'][$quoteDetails]['project_name'] = $projectQuery['project_name']; 
			}

			$quoteProducts['data'][$quoteDetails]['quote_item_id'] = $quoteValues['id'];
			//$quoteProducts['data'][$quoteDetails]['manufacturer'] = $quoteValues['manufacturer'];
			$quoteProducts['data'][$quoteDetails]['product_image'] = getImageBase($quoteProductDetails[0]['product_image'], $_pageName);
			$quoteProducts['data'][$quoteDetails]['quantity'] = $quoteValues['quantity'];
			$quoteProducts['data'][$quoteDetails]['discount'] = $quoteValues['discount'];
			$quoteProducts['data'][$quoteDetails]['temporary_product'] = $temporary_product;
			$quoteProducts['data'][$quoteDetails]['list_price'] = $list_price;
			$quoteProducts['data'][$quoteDetails]['min_price'] = $min_price;
			$quoteProducts['data'][$quoteDetails]['unit_price'] =  $unit_price;
			$quoteProducts['data'][$quoteDetails]['profit'] =  $profit;
			$quoteProducts['data'][$quoteDetails]['profit_percent'] =  $profit_percent;
			$quoteProducts['data'][$quoteDetails]['final_price'] =  number_format((float)($unit_price*$quoteValues['quantity']), 2, '.', '');
			$quoteProducts['data'][$quoteDetails]['rejected_reason'] = $quote['rejected_reason'] > 0 ? $rejectionQuery[$quote['rejected_reason']]['name'] : 0;
			$quoteProducts['data'][$quoteDetails]['item_status'] = $quoteItemStatusQuery[$quoteValues['quote_item_status']]['name'];
			$quoteProducts['data'][$quoteDetails]['quote_item_id'] = $quoteValues['id'];
			$quoteProducts['data'][$quoteDetails]['criteria'] = $quoteValues['criteria'];
			$quoteProducts['data'][$quoteDetails]['destination'] = $quoteValues['destination'];
			$quoteProducts['data'][$quoteDetails]['customer_description'] = $quoteValues['customer_description'];
			$quoteProducts['data'][$quoteDetails]['extra_discount'] = $quote['extra_discount'];
			$quoteProducts['data'][$quoteDetails]['reserved_stock'] = $quoteValues['reserved_stock'];
			$quoteProducts['data'][$quoteDetails]['order_number'] = $quoteValues['order_number'];
			$quoteProducts['data'][$quoteDetails]['ordered_quantity'] = $quoteValues['ordered_quantity'];
			$quoteProducts['data'][$quoteDetails]['order_date'] = $quoteValues['order_date'];
			$quoteProducts['data'][$quoteDetails]['promise_date'] = $quoteValues['promise_date'];
			$quoteProducts['data'][$quoteDetails]['invoiced_quantity'] = $quoteValues['invoiced_quantity'];
			$quoteProducts['data'][$quoteDetails]['aquisition_price'] = intval($quoteValues['aquisition_price']) > 0 ? $quoteValues['aquisition_price'] : $quoteProductDetails[0]['initial_price'];
			

		}

		$quoteQuery[$key]['quote_products'] = $quoteProducts;

		$quoteQuery[$key]['quote_details'] = $quoteItemsQuery;

		$quoteQuery[$key]['client_details'] = $clientQuery[0];

		$quoteQuery[$key]['client_email'] = $clientQuery? $clientQuery[0]['email'] : '';
		$quoteQuery[$key]['client_name'] = $clientQuery? $clientQuery[0]['name'] : '';
		$quoteQuery[$key]['client_poi'] = $clientQuery? $clientQuery[0]['poi'] : '';
		$quoteQuery[$key]['agent_email'] = $GetDetails->userEmail($quote['assignee_id']);
		$quoteQuery[$key]['agent_name'] = $GetDetails->userName($quote['assignee_id']);
		$quoteQuery[$key]['agent_role'] = $GetDetails->userRole($quote['assignee_id']);
		$quoteQuery[$key]['agent_phone'] = $GetDetails->userPhone($quote['assignee_id']);
		$quoteQuery[$key]['rejection_info'] = $quote['rejected_reason'] > 0 ? $rejectionQuery[$quote['rejected_reason']]['name'] : 0;

		if($_pageName == 'quote'|| $_pageName == 'offer') {
			$projectQuery = $QueryBuilder->select(
					$conn,
					$options = array(
						"table" => "projects",
						"columns" => "*",
						"where" => "id = '".$quoteQuery[$key]['project_id']."'"
					)
				);
				$projectQuery = isset($projectQuery[0]) ? $projectQuery[0] : $projectQuery ;
			$quoteQuery[$key]['project_name'] = $projectQuery['project_name'];
		} else {
			$quoteQuery[$key]['project_name'] = $projectQuery['project_name']; 
		}

		//var_dump($quoteQuery[$key]['agent_email']);
	}


	if($_pageName == 'offer') {
		if(isset($_GET['hash'])) {
			if($hashArray && $hashArray[0] == strtotime($quoteQuery[0]['offer_date']) ) {

				$quoteUpdate = $QueryBuilder->update(
					$conn,
					$options = array(
						"table" => "quotes",
						"set" => ["`offer_opened`='1'"],
						"where" => "id = ".$projectID
					)
				);

				include($_MPATH['PROJECTS_VIEWS'].'quote_main_view.php');
			}
			else {
				header("HTTP/1.1 301 Moved Permanently");
				header( 'Location: /404' ) ;
			}
		} 
	}

	// if($_pageName == 'quote') {
	// 	include($_MPATH['PROJECTS_VIEWS'].'quote_main_view.php');
	// }

	// if($_pageName == 'project') {
	// 	include($_MPATH['PROJECTS_VIEWS'].'project_view.php');
	// }

	include($_MPATH['PROJECTS_VIEWS'].'project_view.php');

	
	
$QueryBuilder->closeConnection();

function getImageBase($image_url, $_pageName)
{
		   
	$dataNoImage = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAJYCAYAAAC+ZpjcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo2NDU0OTg2ZC0wZjJhLWU5NGQtOTI3Ny1mMDgxOTM3ZjFhYmUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OTdDM0MwMjA4QUI2MTFFNjlBM0VBQ0EzQkIyNTE1REYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OTdDM0MwMUY4QUI2MTFFNjlBM0VBQ0EzQkIyNTE1REYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUuNSAoV2luZG93cykiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpiNWViZmQ3Mi1iZGM5LWEwNDctYmJjOS1jZjk0NmExNDcyYzAiIHN0UmVmOmRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDo0YjBkNWVmOS04NmQ4LTExZTYtYTNh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66RQjN6eKo3aPnOQ5fau+O/lK/4ME8VI7gAADXOJEABAwAIAELAAAAQsAAAELAAAAQsAQMACAEDAAgAQsAAABCwAAAQsAAABCwBAwAIAELAAABCwAAAELAAAAQsAAAELAEDAAgAQsAAAELAAAAQsAAABCwAAAQsAQMACABCwAAAELAAABCwAAAELAEDAAgBAwAIAELAAAAQsAAAELAAAAQsAQMACAEDAAgAQsAAABCwAAAELAAABCwBAwAIAELAAABCwAAAELAAAAQsAAAELAEDAAgAQsAAAELAAAAQsAAABCwBAwAIAQMACABCwAAAELAAABCwAAAELAEDAAgBAwAIAELAAAAQsAAABCwAAAQsAQMACABCwAAAQsAAABCwAAAELAAABCwBAwAIAELAAABCwAAAELAAAAQsAQMACAEDAAgAQsAAABCwAAAQsAAABCwBAwAIAQMACABCwAAAELAAABCwAAAELAEDAAgAQsAAAELAAAAQsAAABCwAAAQsAQMACABCwAAAQsAAABCwAAAELAAABCwBAwAIAELAAAAQsAAAELAAAAQsAQMACAEDAAgAQsAAABCwAAAQsAAABCwBAwAIAmHD/X4ABABWbGayVdDzuAAAAAElFTkSuQmCC";
		
	if($_pageName != "project" )
	{
	   	// Display the output 

			if($image_url) {
				$image_url = $image_url;
			}else {
				$image_url = "http://ideyafoana.com/api/public/storage/photo/no-image.png";
			}

			$img = @file_get_contents($image_url); 
			  
			// Encode the image string data into base64 
			$data = base64_encode($img); 

			if($img)
				return 'data:image/jpeg;base64,'.$data; 
			else
				return $dataNoImage;

		
	}
	   else
	   	return $dataNoImage;
}
?>
