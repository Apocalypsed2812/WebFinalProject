<?php
	require_once('db.php');
	
	$result = get_role_by_username('anhtien');
	print_r($result);
?>