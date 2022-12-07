<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_POST);

$data = [];

$conn = $QueryBuilder->dbConnection();

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

//var_dump($draw, $row, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $searchValue);


$searchQuery = " ";

if($searchValue != ''){
   $searchQuery = " and (product_name like '%".$searchValue."%' or 
        manufacturer like '%".$searchValue."%' or 
        initial_price like'%".$searchValue."%' or 
        last_crawled_status like'%".$searchValue."%' or 
        id like'%".$searchValue."%' or 
        legacy_id like'%".$searchValue."%' ) ";
}


## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from products");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from products WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *, 

 (
   select 
   sum(qi.reserved_stock)
   from quote_items qi
   where p.id = qi.product_id
) as reserved_quantity


 from products p WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

// echo $empQuery;

$empRecords = mysqli_query($conn, $empQuery);
$data = array();

	// $projectsQuery = $QueryBuilder->select(
	// 	$conn,
	// 	$options = array(
	// 		"table" => "products",
	// 		"columns" => "id, product_image, product_name, manufacturer, is_temporary, initial_price",
	// 		"limit" => 100
	// 	)
	// );

	//var_dump($projectsQuery);

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
   	"id"=>$row['id'],
   	"product_image"=>$row['product_image'],  
      "product_name"=>$row['product_name'],
      "manufacturer"=>$row['manufacturer'],
      "is_temporary"=>$row['is_temporary'],
      "initial_price"=>$row['initial_price'],
      "last_crawled_status"=>$row['last_crawled_status'],
      'merged_id' => $row['merged_id'],
      'legacy_id' => $row['legacy_id'],
      'active' => $row['active'],
      'reserved_quantity' => isset($row['reserved_quantity']) ? $row['reserved_quantity'] : 0  
   );
}


## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);


	$QueryBuilder->closeConnection();
?>