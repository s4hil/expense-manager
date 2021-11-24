<?php
	include 'assets/php/auth.php';
	if (isset($_SESSION['loggedIn'])) {
		if ($_SESSION['loggedIn'] != true) {
			die("Try again with correct credentials!");
		}
	}
	else {
		die("Not Authorized!");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Metas -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Settings - Expense Manager</title>
	<link rel="icon" type="image/x-icon" href="assets/imgs/favicon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/common.css">
	
	<!-- Custom CSS -->
	<style>
		.wrapper {
			display: flex;
		}
		.side-bar {
			width: 200px;
			height: 100vh;
			background: var(--dark);
			position: absolute;
			left: -200px;
			transition: all .3s ease-in-out;
			z-index: 1;
		}
		.show-nav{
			position: absolute;
			left: 0;
		}
		.navbar-nav {
			margin-top: 4rem;
		}
		.nav-link {
			color: #fff;
		}
		.nav-item {
			padding: .25rem;
		}
		.nav-item:hover {
			background: var(--dark-brown);
		}
		.navbar-nav {
			width: 100%;
		}
		.main-section {
			width: 100%;
		}
		.top-bar {
			color: #fff;
			padding: 0.5rem;
			display: flex;
			justify-content: space-between;
			align-items: center;
			background: var(--dark-brown);
			height: 4rem;
			width: 100%;
		}
		.nav-btn {
			border: 1px solid grey;
			padding: .1rem .5rem;
			border-radius: 3px;
			cursor: pointer;
			font-size: 1.5rem;
			position: absolute;
			right: -50px;
			top: 10px;
		}
		.row{
			padding: 0;
			margin: 0;
		}
		.nav-btn i{
			color: #fff;
		}
		.form {
			border: 1px solid grey;
			border-radius: 5px;
			padding: 2rem;
		}
	</style>
</head>
<body>
	<main class="wrapper">
		<aside class="side-bar">
			<?php
				include 'assets/components/sidebar.php';
			?>
		</aside>
		<section class="main-section">
			<div class="top-bar d-flex justify-content-end">
				<div>
					Hi, 
					<?php
						echo ucwords($_SESSION['loggedInUser']);
					?>
					</div>
			</div>
			<div class="content">
				<div class="container-fluid d-flex justify-content-center mt-5 row">
					<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<h2 class="alert alert-info text-center"><i class="fas fa-lock"></i> Change Password</h2>
						<form class="form">
							<fieldset class="form-group">
								<label>Old Password</label>
								<input type="text" id="oldPw" class="form-control">
							</fieldset>
							<fieldset class="form-group">
								<label>New Password</label>
								<input type="text" id="newPw" class="form-control">
							</fieldset>
							<fieldset class="form-group">
								<label>Re-Type Password</label>
								<input type="text" id="confirmNewPw" class="form-control">
							</fieldset>
							<fieldset class="form-group">
								<button type="button" class="btn btn-primary form-control" id="changePw">Change</button>
							</fieldset>

							<div id="msg" class="mt-3"></div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</main>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/settings.js"></script>
</body>
</html>