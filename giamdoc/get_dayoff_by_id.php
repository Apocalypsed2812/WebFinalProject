<?php
	header('Content-Type: application/json; charset = utf8');

	
	require_once('../db.php');
	$id = $_POST['id'];
	$result = get_dayoff_by_id($id);
    $data = $result['data'];
	die(json_encode(array('data'=>$data)));
?>