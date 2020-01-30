<?php 
require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//HTML Artefacts

$LoadHTMLArtefacts->setLink($_WPATH['COMMON_INTERFACE'].'plugins/sweetalert/sweetalert.css');
$LoadHTMLArtefacts->setLink($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css');

$LoadHTMLArtefacts->setLink($_WPATH['COMMON_INTERFACE'].'plugins/dropzone/dropzone.css');

$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-validation/jquery.validate.js');
$LoadHTMLArtefacts->setScript($_WMPATH['CART_VIEWS'].'import-prices.js');

$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/bootstrap-notify/bootstrap-notify.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/sweetalert/sweetalert.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/jquery.dataTables.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/buttons.flash.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/jszip.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/pdfmake.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/vfs_fonts.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/buttons.html5.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/buttons.print.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/dataTables.rowGroup.min.js');

$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/dropzone/dropzone.js');


include($_PATH['COMMON_LAYOUT'].'head.php');
include($_PATH['COMMON_LAYOUT'].'menu-bar.php');

include($_MPATH['CART_CONTROLLERS'].'import_prices_controller.php');

include($_PATH['COMMON_LAYOUT'].'footer.php');




?>