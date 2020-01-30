<?php 

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');



//HTML Artefacts

$LoadHTMLArtefacts->setLink($href=$_WMPATH["AUTH_VIEWS"]."css/auth.css");


//Set Scripts
//====================
$LoadHTMLArtefacts->setScript($src=$_WPATH['COMMON_INTERFACE']."plugins/jquery-validation/jquery.validate.js");
$LoadHTMLArtefacts->setScript($src=$_WPATH['COMMON_INTERFACE']."js/pages/examples/sign-in.js");


//Set Body Classes
//====================
$LoadHTMLArtefacts->setBodyClass('login-page');



include($_PATH['COMMON_LAYOUT'].'head.php');

include($_MPATH['AUTH_CONTROLLERS'].'login-controller.php');

include($_PATH['COMMON_LAYOUT'].'footer.php');


?>