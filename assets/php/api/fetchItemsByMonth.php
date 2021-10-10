<?php
	header("Content-type: application/json");
	include '../auth.php';
	$response = array();
	if (isset($_SESSION['loggedIn'])) {
		if ($_SESSION['loggedIn'] == true) {
			$response['status'] = true;
			include 'api_db_conn.php';
			include_once '../coreFuns.php';
			$user_id = $_SESSION['userID'];
			$monthNumber = getCurrentMonth();

			$sql = "SELECT * FROM `_items` WHERE `user_id` = '$user_id' AND `month` = '$monthNumber' ORDER BY `id` ASC";
			$res = $db->query($sql);
			if ($res) {
				while ($row = $res->fetchArray()) {
					$response['data'][] = $row;
				}
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