<?php
include 'coreFuns.php';
	if (isset($_POST['login'])) {
		include 'config.php';

		$username = strtolower(clean($_POST['username']));
		$pin = clean($_POST['PIN']);

		if ($username != "" && $pin != "" && is_numeric($pin)) {
			$pin = md5($pin);

			$sql = "SELECT * FROM _users WHERE `username`= '$username' AND `pin` = '$pin'";

			$res = $db->query($sql);
			$row = $res->fetchArray(SQLITE3_ASSOC);

			if ($row) {
				if ($row['username'] == $username && $row['pin'] == $pin) {
					$_SESSION['loggedIn'] = true;
					$_SESSION['userID'] = $row['user_id'];
					$_SESSION['loggedInUser'] = $row['username'];
					header('location: ../../home.php');
				}
				else {
					$_SESSION['loggedIn'] = false;
					$_SESSION['msg'] = "Invalid PIN!";
					header('location: ../../index.php');
				}
			}
			else {
				$_SESSION['loggedIn'] = false;
				$_SESSION['msg'] = "Credentials Not Matched!";
				header('location: ../../index.php');
			}
		}
		else {
			$_SESSION['loggedIn'] = false;
			$_SESSION['msg'] = "Invalid Input!";
			header('location: ../../index.php');
		}
	}
?>