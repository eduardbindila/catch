<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config/db.php');

$_VERSION = '0.1.988121';


function getPage(){
	$pageLink = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

	$urlArray = parse_url($pageLink);

	$path = $urlArray['path'];
	$explodeArray = explode('/', $path);

	$section = $explodeArray[1];

	if(isset($explodeArray[2])) {
		$subsection = $explodeArray[2];
	} else {
		$subsection = "";
	}

		

	$pageName =  basename($urlArray['path']);

	if(is_numeric($pageName)) {
		$pageRemoval = ((strlen($pageName)) + 1) *-1;
		
		$pageName = basename(substr($path, 0, $pageRemoval));
	}

	$page  = array('pageName' => $pageName, 'section' => $section, 'subsection' => $subsection );

	return $page;
}


$getPage = getPage();

$_pageName = $getPage['pageName'];

$_sectionName = $getPage['section'];

$_subSectionName = $getPage['subsection'];


// WooCommerce API credentials
$consumer_key = 'ck_6bb064b8c3fc1c48d5c9b4345a0b728733cae950';
$consumer_secret = 'cs_442198654f8dfd30cc06a29773708deeaf3966d7';
$store_url = 'https://shop.icatch.ro';


Class QueryBuilder{

	public function __construct() {
        global $_pageName;
        $this->pageName =& $_pageName;

        global $_DB;
        $this->db =&$_DB;
    }

    function logAction($action, $table, $query, $results){

    	if(($table !== "logs") && ($this->pageName !== "favicon.ico")) {

	    	if((($table == "users") || ($table == "projects") || ($table == "clients")) && ($action == "select"))
	    	{
	    		$results = "sensitive or too long";
	    	}

			$logArray = array(
				"date" => strtotime("now"),
				"user_id" => $_SESSION['user_id'],
				"pageName" => $this->pageName,
				"action" => $action,
				"table" => $table,
				"query" => $query,
				"results" => $results,
				"post" => $_POST
			);

			$logQuery = $this->insert(
				$this->dbConnection(),
				$options = array(
					"table" => "logs",
					"keys" => ["date", "user_id", "page_name", "action", "table_name", "query", "results", "post"],
					"values" => [$logArray['date'], $logArray['user_id'], $logArray['pageName'], $logArray['action'], $logArray['table'], htmlspecialchars(json_encode($logArray['query'])), htmlspecialchars(json_encode($logArray['results'])), htmlspecialchars(json_encode($logArray['post']))]
				)
			);

			//var_dump($logQuery);


    	}
	}

	function dbConnection(){

		$conn = mysqli_connect($this->db['host'], $this->db['user'], $this->db['password'], $this->db['db_name']) or die("Couldn't connect");
        

        return $conn;
    }

    function closeConnection() {
    	mysqli_close($this->dbConnection()); 
    }

	function select($conn, $options, $returnType = 'array'){

		$table = $options['table'];
		$columns = $options['columns'];

		$where = isset($options['where']) ? ' WHERE '.$options['where'] : "";

		$innerJoin = isset($options['innerJoin']) ? ' INNER JOIN '.$options['innerJoin'] : "";


		$leftJoin = isset($options['leftJoin']) ? ' LEFT JOIN '.$options['leftJoin'] : "";

		$limit = isset($options['limit']) ? ' LIMIT '.$options['limit'] : "";

		$offset = isset($options['offset']) ? ' OFFSET '.$options['offset'] : "";

		$orderBy = isset($options['orderBy']) ? ' Order BY '.$options['orderBy'] : "";

		$groupBy = isset($options['groupBy']) ? ' Group BY '.$options['groupBy'] : "";

		$orderType = isset($options['orderType']) ? ' '.$options['orderType'] : "";

		$orderType = isset($options['orderType']) ? ' '.$options['orderType'] : "";

		$columnAsArray = isset($options['columnAsArray']) ? $options['columnAsArray'] : "";

		$columnAsGroup = isset($options['columnAsGroup']) ? $options['columnAsGroup'] : "";

		$allQueryParams = $innerJoin.$leftJoin.$where.$offset.$groupBy.$orderBy.$orderType.$limit;

		$query = 'SELECT '.$columns.' FROM '.$table.' '.$allQueryParams;

		//echo $query;

		$results = mysqli_query($conn, $query);

		if($results) {
			if($returnType == 'array'){
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
					$row = array_map('utf8_encode', $row);
				    array_push($rows, $row);
				}


				//$this->logAction("select", $table, $query, $rows);

				return $rows;
			}
			else if($returnType == 'bol'){
				if(mysqli_num_rows($results) > 0)
			      	return true;
				else
				    return false;
			} else if($returnType == 'insertedProducts'){
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    $rows[$row['id']] = 1;
				    
				}
				//$this->logAction("select", $table, $query, $rows);
				return $rows;
			} else if($returnType == 'idAsArray') {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {

					$rows[$row['id']] = $row;
				    
				}			
				//$this->logAction("select", $table, $query, $rows);
				return $rows;

			} else if($returnType == 'columnAsArray' && isset($options['columnAsArray'])) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {

					$rows[$row[$columnAsArray]] = $row;
				    
				}			
				//$this->logAction("select", $table, $query, $rows);
				return $rows;

			} else if($returnType == 'columnAsGroup' && isset($options['columnAsGroup'])) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {

					if(!isset($rows[$row[$columnAsGroup]]))
						$rows[$row[$columnAsGroup]] = array();

					array_push($rows[$row[$columnAsGroup]], $row);
				    
				}			
				//$this->logAction("select", $table, $query, $rows);
				return $rows;

			}
		}
		else {
			return mysqli_error($conn);
		}		
	}

	function selectFeatures($conn, $productID, $keyFeatures = array()){

		if($keyFeatures) {
			$keyFeaturesArray = $this->arrayToSql($keyFeatures, "'");

			$additionalWhere = " AND features.id in (".$keyFeaturesArray.")";
		}
		else {
			$additionalWhere = '';
		}

		$query = "SELECT Distinct features.feature_name, features.id, feature_values.feature_value, feature_categories.feature_category_name FROM feature_values INNER JOIN product_features ON feature_values.id = product_features.feature_value_id INNER JOIN features ON features.id = product_features.feature_id INNER JOIN feature_categories ON feature_categories.id = features.feature_category_id WHERE product_features.product_id ='".$productID."'".$additionalWhere.";";

		$results = mysqli_query($conn, $query);

		if($results) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    array_push($rows, $row);
				}

				//$this->logAction("selectFeatures", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}		
	}

	function customQuery($conn, $query){

		$results = mysqli_query($conn, $query);

		//echo $query;

		$this->logAction("customQuery", '', $query, "");

		if($results) {
				$rows = array();
				if(is_bool($results)) {

					$rows = (int)$results;

				} else {
					while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
					    array_push($rows, $row);
					}
				}
				

				//$this->logAction("selectFeatures", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}			
	}

	function orderProcessingUpdateStocks($conn, $quote_id)
	{
		$query = "UPDATE
			    quote_items qi,
			    products p
			JOIN(
			    SELECT
			        qi2.id,
			        qi2.product_id,
			        qi2.quantity,
			        p2.saga_quantity,
			        coalesce((p2.saga_quantity + qi2.reserved_stock),0) AS available_product_stock,
			        qi2.reserved_stock,
			        (
			            CASE 
			              	WHEN coalesce((p2.saga_quantity + qi2.reserved_stock),0) = 0 THEN 0
                            WHEN p2.saga_quantity IS NULL THEN 0 
                            WHEN coalesce((p2.saga_quantity + qi2.reserved_stock),0) > qi2.quantity THEN qi2.quantity 
                            WHEN coalesce((p2.saga_quantity + qi2.reserved_stock),0) < qi2.quantity THEN coalesce((p2.saga_quantity + qi2.reserved_stock),0)
                            WHEN coalesce((p2.saga_quantity + qi2.reserved_stock),0) = qi2.quantity THEN qi2.quantity
			        	END
			        ) AS to_reserve
			    FROM quote_items qi2
			    JOIN products p2 ON qi2.product_id = p2.id
			    WHERE qi2.quote_id = '$quote_id'
			) as s
			SET
			    qi.reserved_stock = s.to_reserve,
			    p.saga_quantity = (
			        CASE
			            WHEN s.available_product_stock > s.to_reserve THEN s.available_product_stock - s.to_reserve
			            WHEN s.available_product_stock <= s.to_reserve THEN 0
			            WHEN s.available_product_stock = 0 THEN 0
			            WHEN s.available_product_stock is null THEN 0
			        END
			    )
			WHERE
			    qi.quote_id = '$quote_id' AND 
			    p.id = s.product_id AND
			    qi.id = s.id;";

		$results = mysqli_query($conn, $query);

		if($results) {
				$rows = array();
		
				$this->logAction("reserveStock", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}		
	}

	function selectProjectsData($conn, $isLocked, $thisSession,  $keyFeatures = array() ){

		if($keyFeatures) {
			$keyFeaturesArray = $this->arrayToSql($keyFeatures, "'");

			$additionalWhere = " AND features.id in (".$keyFeaturesArray.")";
		}
		else {
			$additionalWhere = '';
		}

		if(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 6) {
			$restrictQuotesByProfile = "";
		} else {
			$restrictQuotesByProfile = " where `assignee_id` = ".$thisSession['user_id'];
		}

		$query = "SELECT 
				   projects.id 			   AS project_id,
			       projects.project_name   AS project_name,
			       project_status.name     AS project_status, 
			       project_status.id       AS project_status_id, 
			       users.name              AS owner, 
			       clients.name            AS client, 
			       YEAR(quotes.start_date) AS start_year,
			       QUARTER(quotes.start_date) AS start_quarter,
			       MONTH(quotes.start_date) AS start_month,
			       quotes.id,
			       quotes.name,
			       quotes.quote_status,
			       quotes.assignee_id AS assignee_id,
			       quotes.specifyer_designer,
			       quotes.start_date,
			       quotes.client_id,
			       quotes.project_id,
			       quotes.quote_price,
			       quotes.isMaster,   
			       quote_status.name       AS quote_status, 
			       quote_status.id         AS quote_status_id, 
			       specifyer_designer.name AS specifyer_designer, 
			       quotes.winning_chance 
			FROM   quotes
					LEFT JOIN projects 
			              ON quotes.project_id = projects.id
			       LEFT JOIN project_status 
			              ON projects.project_status = project_status.id 
			       LEFT JOIN users 
			              ON projects.owner_id = users.id and users.active = 1
			       LEFT JOIN quote_status 
			              ON quotes.quote_status = quote_status.id 
			       LEFT JOIN specifyer_designer 
			              ON quotes.specifyer_designer = specifyer_designer.id 
			       LEFT JOIN clients 
			              ON quotes.client_id = clients.id".$restrictQuotesByProfile;

		$results = mysqli_query($conn, $query);

		//echo $query;

		

		if($results) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    array_push($rows, $row);
				}

				//$this->logAction("selectProjectsData", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}		
	}

	function selectQuotesData($conn, $client_id, $thisSession){

		if(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 3) {
			
			if(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 6) {
				$where = "";
			} else {
				$where = " WHERE `assignee_id` = ".$_SESSION['user_id'];
			}
		} else {
			$where = "WHERE quotes.client_id =".$client_id." AND quotes.quote_status != 4 OR quotes.assignee_id=".$_SESSION['user_id'];
		}

		$query = "
				SELECT 
		       users.name              AS owner, 
		       clients.name            AS client, 
		       quotes.id,
		       quotes.project_id,
		       quotes.name,
		       quotes.quote_status,
		       quotes.start_date, 
		       quotes.offer_date, 
		       quotes.quote_price      AS project_value, 
		       quote_status.name       AS quote_status, 
		       quote_status.id         AS quote_status_id, 
		       specifyer_designer.name AS specifyer_designer, 
		       quotes.winning_chance 
		FROM   quotes
		       left join users 
		              ON quotes.assignee_id = users.id 
		       left join quote_status 
		              ON quotes.quote_status = quote_status.id 
		       left join specifyer_designer 
		              ON quotes.specifyer_designer = specifyer_designer.id 
		       left join clients 
		              ON quotes.client_id = clients.id ".$where;

		// echo $client_id;

		//echo $query;

		$results = mysqli_query($conn, $query);

		

		if($results) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    array_push($rows, $row);
				}

				//$this->logAction("selectQuotesData", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}	
	}

	function getCategoryBreadcrumbs($conn, $parent_id){


		$query = "

			with recursive parent_users (id, parent_id, category_name, level) AS (
			  SELECT id, parent_id, category_name, 1 level
			  FROM categories
			  WHERE id = '".$parent_id."'
			  union all
			  SELECT t.id, t.parent_id, t.category_name, level + 1
			  FROM categories t INNER JOIN parent_users pu
			  ON t.id = pu.parent_id
			)
			SELECT * FROM parent_users Order By level DESC
		";

		$results = mysqli_query($conn, $query);
		
		if($results) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    array_push($rows, $row);
				}

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}	
	}

	function arrayToSql($thisArray, $sep){
		$sqlString = '';
		$i=1;
		foreach ($thisArray as $key => $value) {

			if(count($thisArray) == $i) {
				$sqlString = $sqlString.$sep.$value.$sep;
			}
			else {
				$sqlString = $sqlString.$sep.$value.$sep.", ";
			}

			$i++;
		}

		return $sqlString;
	}

	function update($conn, $options) {
		$table = $options['table'];

		$set = $this->arrayToSql($options['set'], "");

		$where = isset($options['where']) ? 'WHERE '.$options['where'] : "";

		$join = isset($options['join']) ? ' JOIN '.$options['join'] : "";

		$query = 'UPDATE '.$table.$join.' SET '.$set.' '.$where;

		//echo $query;

		$this->logAction("update", $table, $query, "");

		return $conn->query($query);
	}

	//DELETE from tablename WHERE id IN (1,2,3,...,254);

	function delete($conn, $options) {
		$table = $options['table'];

		$in = $this->arrayToSql($options['in'], "'");

		$column = $options['column'];

		$and = isset($options['and']) ? 'AND '.$options['and'] : "";

		$where = isset($options['where']) ? 'WHERE '.$options['where'] : "";

		$query = 'DELETE from '.$table.' WHERE '.$column.' IN ('.$in.') '.$and;

		//echo $query;
		

		$this->logAction("delete", $table, $query, "");

		return $conn->query($query);
	}

	function insert($conn, $options, $multi=false){

		$table = $options['table'];

		$duplicateKey = isset($options['duplicateKey']) ? $options['duplicateKey'] : "";

		$keys = $this->arrayToSql($options['keys'], "`");

		if($multi) {

			$values = '';

			$i=1;
				
			foreach ($options['values'] as $key => $value) {
				if(count($options['values']) == $i) {
					$sep = '';
				}
				else {
					$sep = ", ";
				}

				$values = $values.'('.$this->arrayToSql($value, '"').')'.$sep;

				$i++;
			};
		}
		else {
			$values = '('.$this->arrayToSql($options['values'], '"').')';

			//echo $values;
		}

		$query = 'INSERT INTO '.$table.' ('.$keys.') VALUES '.$values.$duplicateKey;

		//echo $query;

		$result = $conn->query($query);

		$this->logAction("insert", $table, $query, $result);

		if ($result === TRUE) {
			if($conn->insert_id) {
				return $conn->insert_id;
			} else {
				return $result;
			}
		    
		} else {
		    return 0;
		}
	}

}




// Class WorkingExamples{
//     function getUserInfo($id) {
//         $Dbobj = new DbConnection(); 
//         $query = mysqli_query($Dbobj->getdbconnect(), "SELECT * FROM users");
//         return mysqli_fetch_array($query);
//     }
// }
// $data = new WorkingExamples();
// echo "<pre/>";print_r($data->getUserInfo(3));


Class SessionState {

	 public function __construct() {
        global $_pageName;
        $this->pageName =& $_pageName;
    }

	function sessionStart() {
		// server should keep session data for AT LEAST 1 hour
		ini_set('session.gc_maxlifetime', 36000);

		// each client should remember their session id for EXACTLY 1 hour
		session_set_cookie_params(36000);
		session_start();
		
		// // 
		// if(($this->pageName  !== 'offer') && ($this->pageName  !== 'updateQuote') && ($this->pageName  !== 'getRejectionReason') && ($this->pageName  !== 'confirmQuote')) {
		// 	//$this->redirectLogin();
		// }
		
		
	}

	function redirectLoggedIn(){
		header("location: https://".$_SERVER['HTTP_HOST']."/dashboard");
	}

	function redirectLogin(){
		if($_SERVER["REQUEST_URI"] !== "/auth/login")
			header("location: https://".$_SERVER['HTTP_HOST']."/auth/login");
	}

	function logout(){
		session_destroy();

		$this->redirectLogin();
	}

	function isLoggedIn(){
		if(isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === true){
		    return true;
		}
		else
		{
			return false;
		}
	}


	function destroy(){
		//remove PHPSESSID from browser
		if ( isset( $_COOKIE[session_name()] ) )
		setcookie( session_name(), "", time()-3600, "/" );
		//clear session from globals
		$_SESSION = array();
		//clear session from disk
		session_destroy();
	}

	// function unset() {
	// 	session_unset();
	// }
}



Class LoadHTMLArtefacts{

	public $links = array();

	public $scripts = array();

	public $bodyClasses = array();


	public function __construct() {
        global $_VERSION;
        $this->version =& $_VERSION;
    }

	//Set&Get Links
	//====================
	function setLink($href) {
		array_push($this->links, $href.'?v='.$this->version);
	}


	function printLinks(){
		foreach ($this->links as $link => $value) {
			echo '<link href="'.$value.'" rel="stylesheet">';
		}
	}
	

	//Set&Get Scripts
	//====================
	function setScript($src) {
		array_push($this->scripts, $src.'?v='.$this->version);
	}


	function printScripts(){
		foreach ($this->scripts as $script => $value) {
			echo '<script src="'.$value.'"></script>';
		}
	}

	//Set&Get Body Class
	//====================
	function setBodyClass($class) {
		array_push($this->bodyClasses, $class);
	}


	function printBodyClasses(){

		foreach ($this->bodyClasses as $class => $value) {
			echo $value;
		}
	}



}


Class Pricing {
	public $minPercent = 0.7;
	public $listPercent = 0.28;

	function getListPrice($paPrice) {
		$listPrice = $paPrice/$this->listPercent;

		return  number_format((float)$listPrice, 2, '.', '');
	}

	function getMinPrice($paPrice) {
		$minPrice = $paPrice/$this->minPercent;

		return number_format((float)$minPrice, 2, '.', '');
	}
}



Class GetDetails {

	private $QueryBuilder;

    public function __construct()
    {
        $this->QueryBuilder = new QueryBuilder();
    }


	function userDetails($id) {

		$conn = $this->QueryBuilder->dbConnection();

		$usersQuery = $this->QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "users",
				"columns" => "id, name, email, role, phone",
				"where" => "id = '".$id."'"
			)
		);

		$this->QueryBuilder->closeConnection();

		return $usersQuery;
	}

	function quoteStatus($id) {

		$conn = $this->QueryBuilder->dbConnection();

		$usersQuery = $this->QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_status",
				"columns" => "id, name",
				"where" => "id = '".$id."'"
			)
		);

		$this->QueryBuilder->closeConnection();

		return $usersQuery[0]['name'];
	}

	function userName($id){
		

		if($id > 0) {
			$userInfo = $this->userDetails($id);
			return $userInfo[0]['name'];
		} else 
		{
			return '';
		}
	}

	function userEmail($id){
		if($id > 0) {
			$userInfo = $this->userDetails($id);
			return $userInfo[0]['email'];
		} else 
		{
			return '';
		}

			
	}

	function userRole($id){
		
		if($id > 0) {
			$userInfo = $this->userDetails($id);

			return $userInfo[0]['role'];
		} else 
		{
			return '';
		}
	}

	function userPhone($id){

		if($id > 0) {
			$userInfo = $this->userDetails($id);

			return $userInfo[0]['phone'];
		} else 
		{
			return '';
		}
	}

	function clientDetails($id) {

		$conn = $this->QueryBuilder->dbConnection();

		$usersQuery = $this->QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "clients",
				"columns" => "*",
				"where" => "id = '".$id."'"
			)
		);

		$this->QueryBuilder->closeConnection();

		if(empty($usersQuery)) {
			return 'No Client Assigned';
		} else {
			return $usersQuery[0]['name'];
		}

		
	}

	function isClientValid($id) {

		$conn = $this->QueryBuilder->dbConnection();

		$usersQuery = $this->QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "clients",
				"columns" => "*",
				"where" => "id = '".$id."' and
				(name is not null and name <> '') and 
				(poi is not null and poi <> '') and 
				(email is not null and email <> '') and 
				(phone is not null and phone <> '') and 
				(user_id is not null and user_id <> '') and 
				(fiscal_code is not null and fiscal_code <> '') and 
				(country is not null and country <> '') and 
				(state is not null and state <> '') and 
				(address is not null and address <> '') and 
				(bank_account is not null and bank_account <> '') and
				(bank is not null and bank_account <> '') and  
				(registry is not null and registry <> '') and 
				(discount is not null and discount >0) and 
				active = 1"
			)
		);

		$this->QueryBuilder->closeConnection();

		if(empty($usersQuery)) {
			return 0;
		} else {
			return 1;
		}


		
	}

	function productStock($product_id) {

		$conn = $this->QueryBuilder->dbConnection();

		$productStock = $this->QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "products",
				"columns" => "saga_quantity",
				"where" => "id = '".$product_id."'"
			)
		);

		$this->QueryBuilder->closeConnection();

		return $productStock[0]['saga_quantity'];
	}

	function reservedStock($quote_item_id) {

		$conn = $this->QueryBuilder->dbConnection();

		$productStock = $this->QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_items",
				"columns" => "reserved_stock",
				"where" => "id = '".$quote_item_id."'"
			)
		);

		$this->QueryBuilder->closeConnection();

		return $productStock[0]['reserved_stock'];
	}
}


function getIDByName($name, $list) {

	$biggest_percent = 0;
	$id = 0;
	$userName = '';

	foreach($list as $key=>$list_itemn) {
		similar_text(strtolower($name), strtolower($list_itemn['name']), $percent);

		if($percent > $biggest_percent) {
			$biggest_percent = $percent;
			$id = $list_itemn['id'];
			$userName = $list_itemn['name'];
		} 
	}

	if($biggest_percent < 80) {
		$id = 1;
	}

	return $id;
}


function getMatch($agent, $users_list) {

	$biggest_percent = 0;
	$user_ID = 0;
	$user_name = '';

	foreach($users_list as $key=>$user) {
		similar_text(strtolower($agent), strtolower($user['name']), $percent);

		if($percent > $biggest_percent) {
			$biggest_percent = $percent;
			$user_ID = $user['id'];
			$user_name = $user['name'];
		} 
	}

	return $biggest_percent;
}


function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}


function showError($message) {

	?>

	 <div class="alert generalError bg-pink alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php echo $message ?> <b>Please contact the administrator</b>
    </div>

	<?php


}



$winning_chance = array(
	"4" => "10",
	"7" => "10",
	"3" => "25",
	"1" => "50",
	"5" => "75",
	"2" => "100",
	"8" => "100",
	"9" => "100",
	"10" => "100",
	"11" => "100",
	"12" => "100",
	"13" => "100",
);



function printError($val) {
	
	?>

	 <div class="alert generalError bg-pink alert-dismissible" role="alert">
    <?php 
    	echo "<pre>";
		var_dump($val);
		echo "</pre>";

    ?>
    </div>

	<?php
}



?>
