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
				<div class="row container-fluid mt-5">
					<!-- Controls Column -->
					<div class="col-sm-12 col-md-4 col-lg-3">
						<h2 class="alert alert-success">Controls</h2>
						<form class="form">
							<fieldset class="form-group">
								<label>Year</label>
								<input class="form-control" type="text" id="year" 
								value="<?php echo date('Y'); ?>">
							</fieldset>
							<fieldset class="form-group">
								<label>Select Month</label>
								<select class="form-control" id="month">
									<option value="0">Select</option>
									<option value="1">January</option>
									<option value="2">Febuary</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</fieldset>
							<fieldset class="form-group">
								<button class="form-control btn btn-success" id="load-data">
									<i class="fas fa-table"></i> Load Data
								</button>
								<button class="form-control btn btn-primary mt-3" id="gen-report">
									<i class="fas fa-chart-pie"></i> Generate Report
								</button>
							</fieldset>
						</form>
						<div id="msg"></div>
					</div>

					<!-- Edit Item Column -->
					<div class="col-sm-12 col-md-4 col-lg-3">
						<h2 class="alert alert-success">Edit Item</h2>
						<form class="form" id="edit-item-form">
							<input type="number" id="item-id" hidden>
							<fieldset class="form-group">
								<label>Date</label>
								<input type="date" id="item-date" class="form-control">
							</fieldset>
							<fieldset class="form-group">
								<label>Name</label>
								<input type="text" id="item-name" class="form-control">
							</fieldset>
							<fieldset class="form-group">
								<label>Price</label>
								<input type="text" id="item-price" class="form-control">
							</fieldset>
							<fieldset class="form-group">
								<button disabled class="btn btn-warning form-control" id="update-item">
									<i class="fas fa-check"></i> Update
								</button>
							</fieldset>
						</form>
					</div>

					<!-- Items table column -->
					<div class="col-sm-12 col-md-8 col-lg-6">
						<h2 class="alert alert-success">Data</h2>
						<table class="table table-bordered">
							<thead class="table-dark text-white">
								<tr>
									<th>S.no</th>
									<th>Item Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="items-table">
								<tr>
									<td colspan="3">Use controls to fetch data!</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</section>

		<!-- Item Details Modal -->
		<div class="modal fade" tabindex="-1" id="month-report-modal" aria-hidden="true">
		  <div class="modal-dialog modal-fade">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title"></h5>
		      </div>
		      <div class="modal-body">
		        <ol id="month-items" class="p-3"></ol>
		        <h4 id="totalAmount" class="alert- alert-info p-2"></h4>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" id="hide-report-modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
	</main>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/data.js"></script>
	<script>
		
	// Display Navigation
	let navState = false;
	$(".nav-btn").click(()=>{
		if (navState == false) {
			$(".side-bar").addClass('show-nav');
			navState = true;
		}
		else {
			$(".side-bar").removeClass('show-nav');
			navState = false;
		}
	});

	</script>
</body>
</html>