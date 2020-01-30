<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

// Finally, destroy the session.    
session_destroy();

$SessionState->logout();
?>