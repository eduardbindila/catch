<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$host = "http://{$_SERVER['HTTP_HOST']}";

$urlArray = parse_url($actual_link);

$quoteID = basename($urlArray['path']);

include($_MPATH['QUOTES_VIEWS'].'quote_view.php');
?>