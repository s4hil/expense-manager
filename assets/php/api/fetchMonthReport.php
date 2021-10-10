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
			$year = clean($data['year']);
			$month = clean($data['month']);

			$total = 0;

			$sql = "SELECT * FROM `_items` WHERE 
					`year` = '$year' AND
					`month` = '$month' AND
					`user_id` = '$user_id';
					";
			$res = $db->query($sql);
			if ($res) {
				while ($item = $res->fetchArray(SQLITE3_ASSOC)) {
					$response['data'][] = $item;
					$total += $item['price'];
				}
				$response['status'] = true;
				$response['date'] = $month ." - ". $year;
				$response['total'] = $total;
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