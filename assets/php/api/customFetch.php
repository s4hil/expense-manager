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

			$data = json_decode(file_get_contents("php://input"), true);
			$year = clean($data['year']);	
			$month = clean($data['month']);	

			$sql = "SELECT * FROM `_items` WHERE `user_id` = '$user_id' AND 
					`month` = '$month' AND `year` = '$year' ORDER BY `id` ASC";
			$res = $db->query($sql);
			$num_rows = 0;
			if ($res) {
				while ($row = $res->fetchArray()) {
					$response['data'][] = $row;
					$num_rows++;
				}
				$response['count'] = $num_rows;
			}
			else {
				$response['status'] = false;
				$response['msg'] = "Query Error!";
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