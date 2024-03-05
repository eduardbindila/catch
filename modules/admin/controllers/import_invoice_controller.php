<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$LoadHTMLArtefacts->setScript($_WMPATH['ADMIN_VIEWS'].'import-invoice.js');

include($_MPATH['ADMIN_VIEWS'].'import_invoice_view.php');

?>