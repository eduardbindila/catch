<?php
require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$pathToFile = "uploads/";


if($_SERVER["REQUEST_METHOD"] == "POST") {

?>

<?php
	$import_name = $_POST['name'];
	$import_file = $_POST['file_name'];

	$conn = $QueryBuilder->dbConnection();



	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "import_product_list",
			"keys" => ["name", "file_url", "date_uploaded", "user_id"],
			"values" => [$import_name, $import_file, strtotime("now"), $_SESSION['user_id']]
		)
	);



	if($insertResult > 0) {

		$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

		$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer

		$when = '';

		$ids = '';

		$i = 0;

		$valuesArray = [];

		function fixProductId($product_id)
		{
			if(is_numeric($product_id) && strlen($product_id) < 7 )
			{
				$zeros = str_repeat("0", 7 - strlen($product_id));

				return $zeros.''.$product_id;

			} else {
				return $product_id;
			}
		}

		while(! feof($f_pointer)){
			$product=fgetcsv($f_pointer);

			if($product[0] && $product[1] && $product[2]) {
				$product_id = preg_replace("/[^a-zA-Z 0-9]+/", "",  trim($product[0]));

				$product_name = substr(str_replace("'", "", str_replace('"', "", htmlentities($product[1], ENT_IGNORE))), 0, 253).'...';

				$initial_price = number_format((float)trim($product[2]), 2, '.', '');

				$manufacturer = preg_replace("/[^a-zA-Z 0-9]+/", "",   trim(substr($product[3], 0, 3)));

				//var_dump(htmlentities($product[1], ENT_IGNORE));


				$localArray = array(
					'import_product_list_id' => $insertResult,
					'product' => fixProductId($product_id),
					'product_name' => $product_name,
					'initial_price' =>$initial_price,
					'manufacturer' => $manufacturer
				);

				//var_dump($localArray);
				array_push($valuesArray, $localArray);
			}	
		}


		var_dump($valuesArray);



			$productQuery = $QueryBuilder->insert(
		            $conn,
		            $options = array(
		                "table" => "products_import",
		                "keys" => ["import_product_list_id", "product_id", "name", "price", "manufacturer"],
		                "values" => $valuesArray,
		            ),
		            $multi = true
		            
		        );


			//echo json_encode($productQuery);

			echo $conn->affected_rows.' affected.';
			
		$QueryBuilder->closeConnection();

	}
}

include($_MPATH['MANAGE_PRODUCTS_VIEWS'].'manage_products_view.php');

 ?>