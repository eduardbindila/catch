<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$categoriesTree = $QueryBuilder->getCategoryBreadcrumbs($conn, $_POST['parent_id']);

	echo json_encode($categoriesTree);

$QueryBuilder->closeConnection();


?>