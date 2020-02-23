<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$host = "http://{$_SERVER['HTTP_HOST']}";

$urlArray = parse_url($actual_link);

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

		$quoteQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quotes",
				"columns" => "*",
				"where" => "project_id = '".$projectID."'"
			)
		);
	}

	//Delivered Revenue
	$projectRevenue = array(
		"project_profit" => 0,
		"project_revenue" => 0
	);

	foreach ($quoteQuery as $key => $quote) {
		# code...
		//var_dump($quoteQuery);

		if($quote['quote_status'] == 2) {
			$projectRevenue['project_profit'] = $projectRevenue['project_profit'] + $quote['profit'];
			$projectRevenue['project_revenue'] = $projectRevenue['project_revenue'] + $quote['quote_price'];
		}

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

			if($quoteValues['temporary_product']) {
				$quoteProductDetails = $QueryBuilder->select(
					$conn,
					$options = array(
						"table" => "products_temp",
						"columns" => "id, product_name, product_image, initial_price",
						"where" => "id = '".$quoteValues['product_id']."'"
					)
				);

				$temporary_product = 1;


			}
			else {
				$quoteProductDetails = $QueryBuilder->select(
					$conn,
					$options = array(
						"table" => "products",
						"columns" => "id, product_name, product_image, initial_price",
						"where" => "id = '".$quoteValues['product_id']."'"
					)
				);

				$temporary_product = 0;
			}

			

			if($quoteProductDetails) {
				$quoteProducts['data'][$quoteDetails] = $quoteProductDetails[0];
			}

// 			if($temporary_product == 0) {
// 				$featuresArray = $QueryBuilder->selectFeatures(
// 					$conn, 
// 					$quoteValues['product_id'],
// 					$keyFeatures = array(
// 						"fixture_luminous_flux__lm_", 
// 						'total_power_consumption__w_',
// 						'colour_temperature__k_'

// 					)
// 				);

// 				if($featuresArray){
// 					foreach ($featuresArray as $featureKey => $featureValue) {

// 						$quoteProducts['data'][$quoteDetails][$featureValue['id']] = $featureValue['feature_value'];
// 					}
// 				}
// 			}
			

			

			$list_price = $Pricing->getListPrice($quoteProductDetails[0]['initial_price']);
			$min_price = $Pricing->getMinPrice($quoteProductDetails[0]['initial_price']);

			$unit_price = $quoteValues['unit_price'] > 0 ? $quoteValues['unit_price'] : $list_price - ($quoteValues['discount'] ? ($list_price * $quoteValues['discount']/100) : 0);

			$unit_price = number_format((float)$unit_price, 2, '.', '');

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
				$quoteProducts['data'][$quoteDetails]['project_name'] = "";
			} else {
				$quoteProducts['data'][$quoteDetails]['project_name'] = $projectQuery['project_name']; 
			}
			$quoteProducts['data'][$quoteDetails]['quote_item_id'] = $quoteValues['id'];
			$quoteProducts['data'][$quoteDetails]['product_image'] = getImageBase($quoteProductDetails[0]['product_image']);
			$quoteProducts['data'][$quoteDetails]['quantity'] = $quoteValues['quantity'];
			$quoteProducts['data'][$quoteDetails]['discount'] = $quoteValues['discount'];
			$quoteProducts['data'][$quoteDetails]['temporary_product'] = $temporary_product;
			$quoteProducts['data'][$quoteDetails]['list_price'] = $list_price;
			$quoteProducts['data'][$quoteDetails]['min_price'] = $min_price;
			$quoteProducts['data'][$quoteDetails]['unit_price'] =  $unit_price;
			$quoteProducts['data'][$quoteDetails]['profit'] =  $profit;
			$quoteProducts['data'][$quoteDetails]['profit_percent'] =  $profit_percent;
			$quoteProducts['data'][$quoteDetails]['final_price'] =  $unit_price*$quoteValues['quantity'];
			$quoteProducts['data'][$quoteDetails]['rejected_reason'] = $quote['rejected_reason'] > 0 ? $rejectionQuery[$quote['rejected_reason']]['name'] : 0;
			$quoteProducts['data'][$quoteDetails]['item_status'] = $quoteItemStatusQuery[$quoteValues['quote_item_status']]['name'];
			$quoteProducts['data'][$quoteDetails]['quote_item_id'] = $quoteValues['id'];
			$quoteProducts['data'][$quoteDetails]['criteria'] = $quoteValues['criteria'];
			$quoteProducts['data'][$quoteDetails]['destination'] = $quoteValues['destination'];
			$quoteProducts['data'][$quoteDetails]['customer_description'] = $quoteValues['customer_description'];
			$quoteProducts['data'][$quoteDetails]['extra_discount'] = $quote['extra_discount'];

		}

		$quoteQuery[$key]['quote_products'] = $quoteProducts;

		$quoteQuery[$key]['quote_details'] = $quoteItemsQuery;

		$quoteQuery[$key]['client_email'] = $clientQuery? $clientQuery[0]['email'] : '';
		$quoteQuery[$key]['client_name'] = $clientQuery? $clientQuery[0]['name'] : '';
		$quoteQuery[$key]['client_poi'] = $clientQuery? $clientQuery[0]['poi'] : '';
		$quoteQuery[$key]['agent_email'] = $GetDetails->userEmail($quote['assignee_id']);
		$quoteQuery[$key]['agent_name'] = $GetDetails->userName($quote['assignee_id']);
		$quoteQuery[$key]['agent_role'] = $GetDetails->userRole($quote['assignee_id']);
		$quoteQuery[$key]['agent_phone'] = $GetDetails->userPhone($quote['assignee_id']);
		$quoteQuery[$key]['rejection_info'] = $quote['rejected_reason'] > 0 ? $rejectionQuery[$quote['rejected_reason']]['name'] : 0;
		if($_pageName == 'quote'|| $_pageName == 'offer') {
			$quoteQuery[$key]['project_name'] = ""; 
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

function getImageBase($image_url)
{
	
	if($image_url) {
		$image_url = $image_url;
	}else {
		$image_url = "http://ideyafoana.com/api/public/storage/photo/no-image.png";
	}

	$img = file_get_contents($image_url); 
	  
	// Encode the image string data into base64 
	$data = base64_encode($img); 
	  
	// Display the output 
	return 'data:image/jpeg;base64,'.$data; 
	}
?>