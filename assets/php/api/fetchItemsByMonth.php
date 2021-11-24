<?php
	header("Content-type: application/json");
	include '../auth.php';
// print_r($_SESSION);

	$response = array();
	if (isset($_SESSION['loggedIn'])) {
		if ($_SESSION['loggedIn'] == true) {
			$response['status'] = true;
			include 'api_db_conn.php';
			include_once '../coreFuns.php';
			$user_id = $_SESSION['userID'];
			$monthNumber = getCurrentMonth();
			$count = 0;

			$sql = "SELECT * FROM `_items` WHERE `user_id` = '$user_id' AND `month` = '$monthNumber' ORDER BY `id` ASC";
			$res = $db->query($sql);
			if ($res) {
				while ($row = $res->fetchArray()) {
					$response['data'][] = $row;
					$count++;
				}
			}
			$response['count'] = $count;
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
    // $db->close();
	
?>