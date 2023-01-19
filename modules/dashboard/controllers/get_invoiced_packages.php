<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "packages",
				"columns" => "packages.*, quotes.id as quote_id, quotes.name as quote_name, u.name as owner,
			c.name as client_name, qf.file_path",
				"innerJoin" => ' quotes on packages.quote_id = quotes.id
				join users u on quotes.assignee_id = u.id
			left join clients c on quotes.client_id = c.id
			left join (
			SELECT
			    *
			FROM
			    `quote_files`
			WHERE
			    quote_id = 2478 AND file_type = 1
			ORDER BY
			    id DESC Limit 1
			) qf on quotes.id = qf.quote_id',
				"where" => "package_status_id = 4 ",
				"orderBy" => 'packages.id',
				"orderType" => 'DESC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>