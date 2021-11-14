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
             $removeSlashes = str_replace('Ø', '_', $removeSlashes);
             $removeSlashes = str_replace('.', '_', $removeSlashes);
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
$child_category_class = "product-grid__product-top";
$category_path = $xpath->query('//div[@class="'.$child_category_class.'"]');


 $category_array = array(
        "data" => array(),
    );

foreach ($category_path as $subcategory => $subcategory_value) {

    $bgImage = $subcategory_value->childNodes[1]->attributes[1]->textContent;
    // echo "<pre>";
    // var_dump($subcategory_value->childNodes[1]->attributes[1]);
    // echo "</pre>";
    $subcategory_name = trim($subcategory_value->childNodes[3]->textContent);
    $subcategory_url = $subcategory_value->parentNode->attributes[0]->textContent;
    $subcategory_image = $_ScrapHelpers->getURLfromBg($bgImage);;



    $subcategory_array = array(
        "category_name" => $subcategory_name,
        "category_url" => $subcategory_url,
        "category_slug" => $_POST['parent'].'-'.$_ScrapHelpers->sluggify($subcategory_name),
        "category_image" => $subcategory_image,
        "parent_slug" => $_POST['parent']
    );
    array_push($category_array['data'], $subcategory_array);
}
	echo json_encode($category_array);
?>