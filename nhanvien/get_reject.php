<?php
	header('Content-Type: application/json; charset = utf8');

	
	require_once('../db.php');
	$id = $_POST['id'];
	$result = get_task_rejected($id);
    $data = $result['data'];
	die(json_encode(array('data'=>$data)));
?>