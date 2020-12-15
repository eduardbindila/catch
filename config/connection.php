<?php


function getPage(){
	$pageLink = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

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


Class QueryBuilder{

	public function __construct() {
        global $_pageName;
        $this->pageName =& $_pageName;
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
		if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) { 
		 $conn = mysqli_connect("127.0.0.1","root","","icatch") or die("Couldn't connect");

		} else {
			$conn = mysqli_connect("localhost","eduardbi_icatch","Gkut),1{~R+!","eduardbi_icatchb2b") or die("Couldn't connect");
		}
        
        return $conn;
    }

    function closeConnection() {
    	mysqli_close($this->dbConnection()); 
    }

	function select($conn, $options, $returnType = 'array'){

		$table = $options['table'];
		$columns = $options['columns'];

		$where = isset($options['where']) ? ' WHERE '.$options['where'] : "";

		$innerJoin = isset($options['innerJoin']) ? 'INNER JOIN '.$options['innerJoin'] : "";

		$limit = isset($options['limit']) ? 'LIMIT '.$options['limit'] : "";

		$offset = isset($options['offset']) ? 'OFFSET '.$options['offset'] : "";

		$orderBy = isset($options['orderBy']) ? ' Order BY '.$options['orderBy'] : "";

		$orderType = isset($options['orderType']) ? ' '.$options['orderType'] : "";

		$allQueryParams = $innerJoin.$where.$limit.$offset.$orderBy.$orderType;

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


				$this->logAction("select", $table, $query, $rows);

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
				$this->logAction("select", $table, $query, $rows);
				return $rows;
			} else if($returnType == 'idAsArray') {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {

					$rows[$row['id']] = $row;
				    
				}			
				$this->logAction("select", $table, $query, $rows);
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

		$query = "SELECT Distinct features.feature_name, features.id, feature_values.feature_value, feature_categories.feature_category_name FROM feature_values INNER JOIN product_features ON feature_values.id = product_features.feature_value_id INNER JOIN features ON features.id = product_features.feature_id INNER JOIN feature_categories ON feature_categories.id = features.feature_category_id WHERE product_features.product_id =".$productID.$additionalWhere.";";

		$results = mysqli_query($conn, $query);

		

		if($results) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    array_push($rows, $row);
				}

				$this->logAction("selectFeatures", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}		
	}

	function selectProjectsData($conn, $isLocked, $keyFeatures = array()){

		if($keyFeatures) {
			$keyFeaturesArray = $this->arrayToSql($keyFeatures, "'");

			$additionalWhere = " AND features.id in (".$keyFeaturesArray.")";
		}
		else {
			$additionalWhere = '';
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
			       quotes.specifyer_designer,
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
			              ON projects.owner_id = users.id 
			       LEFT JOIN quote_status 
			              ON quotes.quote_status = quote_status.id 
			       LEFT JOIN specifyer_designer 
			              ON quotes.specifyer_designer = specifyer_designer.id 
			       LEFT JOIN clients 
			              ON quotes.client_id = clients.id ";

		$results = mysqli_query($conn, $query);

		

		if($results) {
				$rows = array();
				while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
				    array_push($rows, $row);
				}

				$this->logAction("selectProjectsData", "", $query, $rows);

				return $rows;
		}
		else {
			return mysqli_error($conn);
		}		
	}

	function selectQuotesData($conn, $client_id){

		if($client_id == 0) {
			$where = "";
		} else {
			$where = "WHERE quotes.client_id =".$client_id." AND quotes.quote_status != 4 OR quotes.assignee_id=".$_SESSION['user_id'];
		}

		$query = "
				SELECT 
		       users.name              AS owner, 
		       clients.name            AS client, 
		       quotes.id,
		       quotes.project_id,
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

				$this->logAction("selectQuotesData", "", $query, $rows);

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

		$query = 'UPDATE '.$table.' SET '.$set.' '.$where;

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
		header("location: http://".$_SERVER['HTTP_HOST']."/dashboard");
	}

	function redirectLogin(){
		if($_SERVER["REQUEST_URI"] !== "/auth/login")
			header("location: http://".$_SERVER['HTTP_HOST']."/auth/login");
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

	//Set&Get Links
	//====================
	function setLink($href) {
		array_push($this->links, $href.'?v=0.1.86');
	}


	function printLinks(){
		foreach ($this->links as $link => $value) {
			echo '<link href="'.$value.'" rel="stylesheet">';
		}
	}
	

	//Set&Get Scripts
	//====================
	function setScript($src) {
		array_push($this->scripts, $src.'?v=0.1.86');
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
		$userInfo = $this->userDetails($id);

		return $userInfo[0]['name'];
	}

	function userEmail($id){
		$userInfo = $this->userDetails($id);

		return $userInfo[0]['email'];
	}

	function userRole($id){
		$userInfo = $this->userDetails($id);

		return $userInfo[0]['role'];
	}

	function userPhone($id){
		$userInfo = $this->userDetails($id);

		return $userInfo[0]['phone'];
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



$winning_chance = array(
	"4" => "10",
	"7" => "10",
	"3" => "25",
	"1" => "50",
	"5" => "75",
	"2" => "100"
);




// $strtotime = strtotime("now");

// echo $strtotime;  
// echo uniqid($strtotime);

?>