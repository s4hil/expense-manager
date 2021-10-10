<?php
	header("Content-type: application/json");
	include '../auth.php';
	$response = array();
	if (isset($_SESSION['loggedIn'])) {
		if ($_SESSION['loggedIn'] == true) {
			include 'api_db_conn.php';
			include_once '../coreFuns.php';
			$user_id = $_SESSION['userID'];

			// Code goes here 
			$data = json_decode(file_get_contents("php://input"), true);

			// Sanitize Input
			$id = clean($data['item_id']);

			$sql = "SELECT * FROM `_items` WHERE `id`='$id' LIMIT 1";
			$res = $db->query($sql);
			if ($res) {
				$item = $res->fetchArray(SQLITE3_ASSOC);
				$response['status'] = true;
				$response['data'] = $item;
			}
			else{
				$response['status'] = false;
				$response['msg'] = "Inavlid Input, Query Error!";
			}
		}
		else {
			$response['status'] = false;
			$response['msg'] = "Invalid Credentials!";
		}
	}
	else{
		$response['status'] = false;
		$response['msg'] = "Unauthorized!";
	}
	echo json_encode($response);
?>