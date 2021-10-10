<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Sign Up - Expense Manager</title>
	<link rel="icon" type="image/x-icon" href="assets/imgs/favicon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/common.css">

	<script src="assets/js/jquery.min.js"></script>

	
	<style>
		.wrapper {
			background: var(--dark);
			width: 100%;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.header span{
			border-radius: .25rem;
			padding: 0 .3rem;
			animation: blink 1.5s infinite;
		}
		@keyframes blink {
			0%{
				opacity: 1;
			}
			50%{
				opacity: 0;
			}
			100%{
				opacity: 1;
			}
		}
		.login-container {
			background: var(--dark-brown);
			padding: 5rem 2rem 2rem 2rem;
			border-radius: 1.5rem;
			color: #fff;
		}
		.logo-container {
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.logo-container img {
			overflow: hidden;
			border: 1px solid white;
			border-radius: 50%;
			width: 120px;
			height: 120px;
			transform: translateY(50%);
			background: #fff;
			margin-top: -60px;
		}
	</style>
</head>
<body>
	<main class="wrapper">
		<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-4">
			<div class="logo-container">
				<img src="assets/imgs/logo.png">
			</div>
			<div class="login-container">
			<h2 class="header text-center text-white">
				<span class="bg-danger text-white">Expense Manager</span>
				<h4 class="text-center">Sign Up</h4>
			</h2>
			<form class="form sign-up-form" autocomplete="off" action="?" method="POST">
				<fieldset class="form-group">
					<label>Username</label>
					<input type="text" name="username" class="form-control">
				</fieldset>
				<fieldset class="form-group">
					<label>PIN</label>
					<input type="number" name="pin" class="form-control">
				</fieldset>
				<fieldset class="form-group">
					<label>Mobile Number</label>
					<input type="text" name="number" class="num-only form-control" placeholder="Enter 10 digit mobile number">
				</fieldset>
				<fieldset class="form-group">
					<button name="sendOTP" class="btn btn-primary float-right">Send OTP</button>
				</fieldset>
			</form>
			
			<?php
				// Handle Submission
				if (isset($_POST['sendOTP'])) {
					include 'assets/php/coreFuns.php';
				 	$username = clean($_POST['username']);
				 	$pin = clean($_POST['pin']);
				 	$number = clean($_POST['number']);

				 	$otp = rand(1000,9999);
				 	$_SESSION['OTPcode'] = $otp;

					if (sendOTP($number, $otp) == true) {
						echo $otp;
						?>
							<script>
								$(".sign-up-form").hide();
							</script>
							<form class="form" method="POST" action="?">
								<fieldset class="form-group">
									<label>OTP</label>
									<input type="number" name="enteredOTP" class="form-control">
								</fieldset>
								<fieldset class="form-group">
									<button name="verifyOTP" class="btn btn-success">Verify</button>
								</fieldset>
							</form>
							<?php

								if (isset($_POST['verifyOTP'])) {
									$enteredOTP = clean($_POST['enteredOTP']);
									if ($enteredOTP == $_SESSION['OTPcode']) {
										unset($_SESSION['OTPcode']);
										include 'assets/php/config.php';

										$sql = "INSERT INTO `_users` (`username`, `pin`,`number`) VALUES (
												'$username',
												'$pin',
												'$number'
											)";
										$res = $db->exec($sql);
										if ($res) {
											?>
												<script>
													alert('User Added!');
												</script>
											<?php
										}
										else {
											?>
												<script>
													alert('User Not Added!');
												</script>
										<?php
										}
									}
								}

							?>
						<?php
					}
					else {
						alertUser("Failed To Send OTP");
					}
					
				} 

			?>
			
			<div id="output-box"></div>
			<p class="text-center">
				<a href="index.php"> Login</a>
			</p>
		</div>
		</div>
	</main>
	<script src="assets/js/createAccount.js"></script>
	<script>
		$(".num-only").keyup(function(e){
		    if (/\D/g.test(this.value))
		    {
		        this.value = this.value.replace(/\D/g, '');
		    }
		});
	</script>
</body>
</html>