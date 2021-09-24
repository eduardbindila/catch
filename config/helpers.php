<?php

//========= PATHS ========//


//DOCUMENT PATHS
//========================//
$_PATH['COMMON_INTERFACE'] = $_SERVER['DOCUMENT_ROOT'].'/common/interface/';
$_PATH['COMMON_BACKEND'] = $_SERVER['DOCUMENT_ROOT'].'/common/backend/';

$_PATH['COMMON_VIEW'] = $_PATH['COMMON_INTERFACE'].'views/';

$_PATH['COMMON_LAYOUT'] = $_PATH['COMMON_INTERFACE'].'views/layout/';



//WEB PATHS
//========================//
$_WPATH['COMMON_INTERFACE'] = '/common/interface/';
$_WPATH['COMMON_BACKEND'] = '/common/backend/';

$_WPATH['COMMON_VIEW'] = $_WPATH['COMMON_INTERFACE'].'views/';

$_WPATH['COMMON_LAYOUT'] = $_WPATH['COMMON_INTERFACE'].'views/layout/';


//MODULE PATHS
//========================//
$_MPATH["MODULES"] = $_SERVER['DOCUMENT_ROOT'].'/modules/';

$_MPATH["AUTH_CONTROLLERS"] = $_MPATH["MODULES"]."auth/controllers/";
$_MPATH["AUTH_VIEWS"] = $_MPATH["MODULES"]."auth/views/";

$_MPATH["DASHBOARD"] = $_MPATH["MODULES"]."dashboard/";
$_MPATH["DASHBOARD_VIEWS"] = $_MPATH["MODULES"]."dashboard/views/";

$_MPATH["ADMIN"] = $_MPATH["MODULES"]."admin/";
$_MPATH["CART"] = $_MPATH["MODULES"]."cart/";
$_MPATH["PROJECTS"] = $_MPATH["MODULES"]."projects/";

$_MPATH["DASHBOARD"] = $_MPATH["MODULES"]."dashboard/";

$_MPATH["IMPORT_CATEGORIES"] = $_MPATH["ADMIN"].'import/categories/'; 
$_MPATH["IMPORT_CATEGORIES_CONTROLLERS"] = $_MPATH["IMPORT_CATEGORIES"]."controllers/";
$_MPATH["IMPORT_CATEGORIES_VIEWS"] = $_MPATH["IMPORT_CATEGORIES"]."views/";

$_MPATH["ADMIN_CONTROLLERS"] = $_MPATH["ADMIN"]."controllers/";
$_MPATH["ADMIN_VIEWS"] = $_MPATH["ADMIN"]."views/";

$_MPATH["IMPORT_ELEMENTS"] = $_MPATH["ADMIN"].'import/elements/'; 
$_MPATH["IMPORT_ELEMENTS_CONTROLLERS"] = $_MPATH["IMPORT_ELEMENTS"]."controllers/";
$_MPATH["IMPORT_ELEMENTS_VIEWS"] = $_MPATH["IMPORT_ELEMENTS"]."views/";

$_MPATH["IMPORT_PRODUCTS"] = $_MPATH["ADMIN"].'import/products/'; 
$_MPATH["IMPORT_PRODUCTS_CONTROLLERS"] = $_MPATH["IMPORT_PRODUCTS"]."controllers/";
$_MPATH["IMPORT_PRODUCTS_VIEWS"] = $_MPATH["IMPORT_PRODUCTS"]."views/";

$_MPATH["MANAGE_PRODUCTS"] = $_MPATH["ADMIN"].'manage/'; 
$_MPATH["MANAGE_PRODUCTS_CONTROLLERS"] = $_MPATH["MANAGE_PRODUCTS"]."controllers/";
$_MPATH["MANAGE_PRODUCTS_VIEWS"] = $_MPATH["MANAGE_PRODUCTS"]."views/";


$_MPATH["CART_VIEWS"] = $_MPATH["CART"]."views/";
$_MPATH["CART_CONTROLLERS"] = $_MPATH["CART"]."controllers/";

$_MPATH["PROJECTS_VIEWS"] = $_MPATH["PROJECTS"]."views/";
$_MPATH["PROJECTS_CONTROLLERS"] = $_MPATH["PROJECTS"]."controllers/";

$_MPATH["DASHBOARD_VIEWS"] = $_MPATH["DASHBOARD"]."views/";
$_MPATH["DASHBOARD_CONTROLLERS"] = $_MPATH["DASHBOARD"]."controllers/";


//MODULE WEB PATHS
//========================//
$_WMPATH["MODULES"] = '/modules/';

$_WMPATH["AUTH_CONTROLLERS"] = $_WMPATH["MODULES"]."auth/controllers/";
$_WMPATH["AUTH_VIEWS"] = $_WMPATH["MODULES"]."auth/views/";

$_WMPATH["ADMIN_VIEWS"] = $_WMPATH["MODULES"]."admin/views/";

$_WPATH["IMPORT_CATEGORIES_VIEWS"] = $_WMPATH["MODULES"]."admin/import/categories/views/";

$_WPATH["IMPORT_PRODUCTS_VIEWS"] = $_WMPATH["MODULES"]."admin/import/products/views/";

$_WMPATH["IMPORT_ELEMENTS_VIEWS"] = $_WMPATH["MODULES"]."admin/import/elements/views/";

$_WMPATH["CART_VIEWS"] = $_WMPATH["MODULES"]."cart/views/";

$_WMPATH["PROJECTS_VIEWS"] = $_WMPATH["MODULES"]."projects/views/";

$_WMPATH["DASHBOARD_VIEWS"] = $_WMPATH["MODULES"]."dashboard/views/";


$_WMPATH["MANAGE_VIEWS"] = $_WMPATH["MODULES"]."admin/manage/views/";




//========= LAYOUT ========//


//THEMES
//========================//
$_THEME['COLOR'] = 'blue';



?>