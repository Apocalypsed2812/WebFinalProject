<?php
	header('Content-Type: application/json; charset = utf8');

    if (empty($_POST['id_task']) || empty($_POST['description']) || empty($_POST['deadline'])){
            die(json_encode(array('data'=>'dữ liệu không hợp lệ')));
        }
	
	require_once('../db.php');
	$id_task = $_POST['id_task'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    if (empty($_POST['id_employee'])){
        $result =  update_task($id_task, $description, $deadline);
    } else {
        $result =  update_task_new($id_task, $_POST['id_employee'], $description, $deadline);
    }

	die(json_encode(array('data'=>'thành công')));
?>