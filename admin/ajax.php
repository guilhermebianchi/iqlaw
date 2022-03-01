<?php
include '../core.php';
include '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['login'])) {
	$json = array();
} else {
	switch ($_GET['action']) {
		case 'unique':
			$value = $_POST['value'];
			$data = db::get_by_conditions($_GET['page'] ,array(
				$_GET['field'] => $_POST['value']
			));
			
			$json['success'] = empty($data);
		break;
	}
}

echo json_encode($json);