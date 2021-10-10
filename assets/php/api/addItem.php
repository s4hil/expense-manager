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
			$date = clean($data['date']);
			$item = ucwords(clean($data['item']));
			$price = clean($data['price']);
			$month = getMonthByFullDate($date);
			$year = getYearByFullDate($date);

			$sql = "INSERT INTO `_items` (`item_name`,`price`,`month`,`year`,`date`,`user_id`) VALUES(
					'$item',
					'$price',
					'$month',
					'$year',
					'$date',
					'$user_id'
					)";
			$res = $db->exec($sql);
			if ($res) {
				$response['status'] = true;
				$response['msg'] = "Item Added!";
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