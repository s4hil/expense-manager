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
			$id = clean($data['id']);
			$date = clean($data['date']);
			$item = ucwords(clean($data['name']));
			$price = clean($data['price']);
			$month = getMonthByFullDate($date);
			$year = getYearByFullDate($date);

			$sql = "UPDATE `_items` SET 
					`date` = '$date',
					`item_name` = '$item',
					`price` = '$price',
					`month` = '$month',
					`year` = '$year' WHERE `id` = '$id'";
			$res = $db->exec($sql);
			if ($res) {
				$response['status'] = true;
				$response['msg'] = "Details Updated!";
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