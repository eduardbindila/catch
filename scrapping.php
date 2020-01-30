<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 
echo 'ET calls home<br>';

$root = "https://www.sylvania-lighting.com";

$categories_url = $root."/product/en-int/categories/";

    $html = file_get_contents($categories_url);
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $category_array = array();


    CLASS ScrapHelpers {

        function sluggify($s){
            return strtolower(str_replace(' ', '_', $s));
        }

        function getURLfromBg($bg) {
            $bgImage = explode('(', $bg);
            $bgImage = explode(')', $bgImage[1])[0];
            return $bgImage;
        } 

        function scrapChild($children_URL, $parent_index, $parent_slug) {

            $root = "https://www.sylvania-lighting.com";
            $child_category_class = "product-grid__product-top";

            $html = file_get_contents($root.$children_URL);
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            $category_path = $xpath->query('//div[@class="'.$child_category_class.'"]');

            $local_array = array();

            foreach ($category_path as $subcategory_index => $subcategory_value) {
                
                $subcategory_name = trim($subcategory_value->childNodes[3]->textContent);
                $subcategory_url = $subcategory_value->parentNode->attributes[0]->textContent;
                $subcategory_image = '';

                $category_length = sizeof($category_path)-1;



                $subcategory_array = array(
                    "category_name" => $subcategory_name,
                    "category_url" => $subcategory_url,
                    "category_image" => $subcategory_image,
                    "category_slug" =>$this->sluggify($subcategory_name),
                    "parent_slug" => $parent_slug,
                    "parent_index" => $parent_index,
                    "children" => array()
                );

                array_push($local_array, $subcategory_array);
            }



            return $local_array;
        }
    }

    $_ScrapHelpers = new ScrapHelpers();



    //========= XPATH CLASSES ==========
    $main_category_class = "product-grid__item col col-6";
    $child_category_class = "product-grid__product-top";

    $main_category = $xpath->query('//div[@class="'.$main_category_class.'"]');


    foreach ($main_category as $category_index => $value) {

        //========= NODE NAVIGATION HELPERS ==========
        $main_category_wrapper = $value->childNodes[1];
        $main_category_info = $main_category_wrapper->childNodes[1];
        $bgImage = $main_category_info->childNodes[1]->attributes[1]->textContent;


        //========= ARRAY VARS ==========
        $main_category_image = $_ScrapHelpers->getURLfromBg($bgImage);
        $main_category_name = trim($main_category_info->childNodes[3]->textContent);
        $main_category_url = $main_category_wrapper->attributes[1]->textContent;
        $main_category_slug = $_ScrapHelpers->sluggify($main_category_name);

       $main_category_array = array(
        "category_slug" => $main_category_slug,
        "category_name" => $main_category_name,
        "category_image" => $main_category_image,
        "category_url" => $main_category_url,
        "children" => array()
       );

       $children_url_array = array();

       $subcategory_info = array(

        "child_url" => $main_category_array['category_url'],
        "parent_slug" => $main_category_array['category_slug']

       );



       // if(isset($main_category_array['category_url'])) {

            array_push($children_url_array, $subcategory_info);


            foreach ($children_url_array as $child_url_index => &$child_info) {

                 // echo '<pre>';
                 //    print_r($child_info);
                 //    echo '</pre>';


                $child_url_value = $child_info['child_url'];
                $parent_slug = $child_info['parent_slug'];

                //break;

                $html = file_get_contents($root.$child_url_value);
                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                $dom->loadHTML($html);
                $xpath = new DOMXPath($dom);

                $category_path = $xpath->query('//div[@class="'.$child_category_class.'"]');



                foreach($category_path as $child_index => $child_value) {

                    $subcategory_name = trim($child_value->childNodes[3]->textContent);
                    $subcategory_url = $child_value->parentNode->attributes[0]->textContent;
                    $subcategory_image = '';

                    $subcategory_array = array(
                        "category_name" => trim($subcategory_name),
                        'category_slug' => $_ScrapHelpers->sluggify($subcategory_name),
                        "category_url" => $subcategory_url,
                        "category_image" => $subcategory_image,
                        "parent_slug" => $parent_slug
                    );


                    // echo '<pre>';
                    // print_r($subcategory_array);
                    // echo '</pre>';

                     // if($subcategory == 0)
                     //            break;

                    array_push($main_category_array['children'], $subcategory_array);

                    $subcategory_info = array(

                        "child_url" => $subcategory_array['category_url'],
                        "parent_slug" => $subcategory_array['category_slug']

                    );

                    array_push($children_url_array, $subcategory_info);

                    // echo '<pre>';
                    // print_r($children_url_array);
                    // echo '</pre>';


                }

                 // echo '<pre>';
                 //    print_r($children_url_array);
                 //    echo '</pre>';

            
            // if($category_index == 0)
            //     break;


       //  do {

       //      $html = file_get_contents($root.$children_url);
       //      libxml_use_internal_errors(true);
       //      $dom = new DOMDocument();
       //      $dom->loadHTML($html);
       //      $xpath = new DOMXPath($dom);

       //      $category_path = $xpath->query('//div[@class="'.$child_category_class.'"]');


       //      foreach ($category_path as $subcategory => $subcategory_value) {
                
       //          $subcategory_name = trim($subcategory_value->childNodes[3]->textContent);
       //          $subcategory_url = $subcategory_value->parentNode->attributes[0]->textContent;
       //          $subcategory_image = '';



       //          $subcategory_array = array(
       //              "category_name" => $subcategory_name,
       //              "category_url" => $subcategory_url,
       //              "category_image" => $subcategory_image
       //          );


       //          // echo '<pre>';
       //          // print_r($subcategory_array);
       //          // echo '</pre>';

       //           // if($subcategory == 0)
       //           //            break;

       //          array_push($main_category_array['children'], $subcategory_array);

               
       //      }

       //      $children_url = NULL;



       //  } while(isset($children_url));

       // }




       //  //========= INITIAL VARS ==========
       //  $children_URL = $main_category_array['category_url'];
       //  $parent_slug = $main_category_array['category_slug'];
       //  $parent_index = $category;
       //  $parent_category = array();

       //  do {

       //      // $thisAarray = $_ScrapHelpers->scrapChild($children_URL, $parent_index, $parent_slug);

            
       //      // $local_category = &$thisAarray;

       //      // $next_parent_index = $parent_index++;

       //      // if($local_category[0]["category_url"]) {
       //      //     $parent_index = 0;
       //      //     $local_category = &$thisAarray[$parent_index];
                   
       //      // }
       //      // else if($local_category[$next_parent_index]["category_url"]) {
       //      //     $parent_index = $next_parent_index;
       //      //     $local_category = &$thisAarray[$parent_index];
       //      // } else {
       //      //     $children_URL = NULL;
       //      // }


           
       //      // $children_URL = $local_category['category_url'];
       //      // $parent_slug = $local_category['category_slug'];

       //      // $local_array = $_ScrapHelpers->scrapChild($children_URL, $parent_index, $parent_slug);

       //      // array_push($local_category['children'], $local_array);



       //      // echo '<pre>';
       //      // print_r($thisAarray);
       //      // echo '</pre>';


            




       //          // if($subcategory_length == $subcategory_index)
       //          // {
       //          //     echo 'the end baby'.$subcategory_length.' - '.$subcategory;

       //          //     $local_category = $local_array[0];

       //          //     if($local_category["category_url"]) {

       //          //         $children_URL = $local_category['category_url'];
       //          //         $parent_slug = $local_category['category_slug'];
       //          //         $parent_index = 0;

                        
       //          // echo '<pre>';
       //          // print_r($local_array);
       //          // echo '</pre>';
       //          //         $local_array = array();
       //          //     } 
       //          //     else {
       //          //         // $children_URL = $local_category['category_url'];
       //          //         // $parent_slug = $local_category['category_slug'];
       //          //         // $parent_index = 0;

       //          //          //$children_URL = NULL;
       //          //     }


                    


       //          //  }

       //          //  if($subcategory_index = 40) {
       //          //         $children_URL = NULL;
       //          //     }
                 

       //          //array_push($main_category_array['children'], $subcategory_array);


       //  } while(isset($children_URL));






        // echo '<pre>';
        // print_r($main_category_array);
        // echo '</pre>';


        // $links = $value->childNodes[3]->childNodes;

        // foreach ($links as $link => $linkValue) {
        //     # code...

        //     if(isset($linkValue->tagName) && $linkValue->tagName == 'a')
        //     {

        //             $main_sub_category_name = $linkValue->textContent;

        //             $main_sub_category_url = $linkValue->attributes[0]->textContent;


        //            echo "<pre>";
        //             echo $main_sub_category_name;

        //             echo '</br>'.$main_sub_category_url;
                    
        //             echo "</pre>";

        //             }
        //     }

         

        // $title = $value->nodeValue;

        // $url = $value->attributes[0];



        // echo $title;
        // print_r($url);



        // $main_category_url = $xpath->query('//a[contains(@class,"'.$main_category_url_class.'")]')[$category]->getAttribute('href');
        // $main_category_title = $xpath->query('//div[contains(@class,"'.$main_category_title_class.'")]')[$category]->nodeValue;

        
        //echo $main_category_title.' - '.$main_category_url.'<br>';

            if($category_index == 0)
                break;

       array_push($category_array, $main_category_array);

    }
}

    echo '<pre>';
    print_r($category_array);
    echo '</pre>';





    // foreach ($product_codes as $product) {

    // $the_site = "https://www.sylvania-lighting.com/product/en-int/products/00".$product."/";
    //     $product_image_class = "product-overview__image";
    //     $product_title_class = "intro-block__title";
    //     $product_description_class = "product-overview__copy";
    //     $product_infopanels_class = "info-panels";

    //     $html = file_get_contents($the_site);
    //     libxml_use_internal_errors(true);
    //     $dom = new DOMDocument();
    //     $dom->loadHTML($html);
    //     $xpath = new DOMXPath($dom);

    // //Scrapping Image

    //     $product_image = $xpath->query('//div[contains(@class,"'.$product_image_class.'")]/img')[0]->getAttribute('src');

    //     $product_title = $xpath->query('//h1[contains(@class,"'.$product_title_class.'")]')[0]->nodeValue;

    //     $product_description = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_description_class.'")]')[0]);

    //     $product_infopanels_class = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")]')[0]);

    //     print_r($product_title);

    //     print_r($product_description);

    //     print_r($product_infopanels_class);




    //     echo '<div>'.$product.' </div><div><img width="20%" src="'.$product_image.'" /></div>';

    // }

 // echo '<pre>';
 //                print_r($category_array);
 //                echo '</pre>';

?>