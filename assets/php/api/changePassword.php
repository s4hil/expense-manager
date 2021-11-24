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

			$oldPw = $data['oldPw'];
			$newPw = $data['newPw'];

			// $oldPw = "12345678";
			// $newPw = "1234";

			if (verifyOldPw($user_id, $oldPw) == true) {
				if (setNewPassword($user_id, $newPw) == true) {
					$response['status'] = true;
					$response['msg'] = "Password Changed Successfully!";
				}
				else{
					$response['status'] = false;
					$response['msg'] = "Failed To Set Old Password!";
				}
			}
			else {
				$response['status'] = false;
				$response['msg'] = "Incorrect Old Password!";
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