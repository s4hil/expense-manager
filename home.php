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

	<title>Home - Expense Manager</title>
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
					<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<h2 class="alert alert-info">Add Item</h2>
						<form class="form add-item-form" autocomplete="off">
							<fieldset class="form-group">
								<label>Date</label>
								<input type="date" id="date" class="form-control" required>
							</fieldset>
							<fieldset class="form-group">
								<label>Item</label>
								<input type="text" id="item" class="form-control" required>
							</fieldset>
							<fieldset class="form-group">
								<label>Price</label>
								<input type="text" id="price" class="form-control" required>
							</fieldset>
							<fieldset class="form-group">
								<button class="btn btn-primary" id="add-item"><i class="fas fa-save"></i> Add</button>
							</fieldset>
						</form>
						<div id="msg"></div>
					</div>
					<div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-8">
						<h2 class="alert alert-info">Items
							<span style="font-size: .9rem;">(<?php echo date('m-Y'); ?>)</span>
						</h2>
						<table class="table table-striped">
							<thead>
								<tr class="bg-dark text-white">
									<th>Date</th>
									<th>Item</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="items-table">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
	</main>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/home.js"></script>
</body>
</html>