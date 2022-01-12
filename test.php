<?php
	require_once('db.php');
	
	$result = count_task_submit('T001')['count(*)'];
	print_r($result);
?>