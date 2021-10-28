<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Login - Expense Manager</title>
	<link rel="icon" type="image/x-icon" href="assets/imgs/favicon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/common.css">

	<!-- Basic Metas -->
	
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
			</h2>
			<?php
				include 'assets/php/auth.php';
				if (isset($_SESSION['msg'])) {
					?>
						<div class="alert alert-warning mt-3">
							<?php
								echo $_SESSION['msg'];
								unset($_SESSION['msg']);
							?>
						</div>
					<?php
				}
			?>
			<form class="form" method="POST" action="assets/php/auth.php">
				<fieldset class="form-group">
					<label for="username">Username</label>
					<input required type="text" name="username" id="username" class="form-control">
				</fieldset>
				<fieldset class="form-group">
					<label for="pin">PIN</label>
					<input required type="password" name="PIN" maxlength="6" id="pin" class="form-control">
				</fieldset>
				<fieldset class="form-group">
					<button name="login" type="submit" class="btn btn-success float-right">Login</button>
				</fieldset>
			</form>
			<p class="text-center">
				<a href="createAccount.php">Create Account?</a>
			</p>
		</div>
		</div>
	</main>
	<script src="assets/js/jquery.min.js"></script>
	<script>
		$("#pin").keyup(function(e){
		    if (/\D/g.test(this.value))
		    {
		        this.value = this.value.replace(/\D/g, '');
		    }
		});
	</script>
</body>
</html>
<?php
	
?>