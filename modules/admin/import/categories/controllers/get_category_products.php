<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

$root = "https://www.sylvania-lighting.com";

CLASS ScrapHelpers {

        function sluggify($s){
             $removeSlashes = str_replace('/', '_', $s);
             $removeSlashes = str_replace('&', '_', $removeSlashes);
             $removeSlashes = str_replace('(', '_', $removeSlashes);
             $removeSlashes = str_replace(')', '_', $removeSlashes);
             $removeSlashes = str_replace('+', '_', $removeSlashes);
            return strtolower(str_replace(' ', '_', $removeSlashes));
        }

        function getURLfromBg($bg) {
            $bgImage = explode('(', $bg);
            $bgImage = explode(')', $bgImage[1])[0];
            return $bgImage;
        } 
    }

    $_ScrapHelpers = new ScrapHelpers();



$html = file_get_contents($root.$_POST['childURL']);
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$child_category_class = "table__tbody__td table__tbody__td--pcode";
$category_path = $xpath->query('//td[@class="'.$child_category_class.'"]');


 $category_array = array(
        "data" => array(),
    );

foreach ($category_path as $subcategory => $subcategory_value) {

    $product_id = trim($subcategory_value->childNodes[0]->textContent);
    $subcategory_array = array(
        "product_id" => $product_id,
    );

    array_push($category_array['data'], $subcategory_array);
}

	echo json_encode($category_array);
?>