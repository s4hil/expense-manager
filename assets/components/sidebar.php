<nav class="navbar">
<div class="nav-btn"><i class="nav-icon text-white fas fa-bars"></i></div>
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="home.php">
				<i class="fas fa-home"></i> Home
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="data.php">
				<i class="fas fa-database"></i> Data
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="settings.php">
				<i class="fas fa-cogs"></i> Settings
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="?logout">
				<i class="fas fa-power-off"></i> Logout
			</a> 
			<?php
				if (isset($_GET['logout'])) {
					session_destroy();
					header('location: index.php');
				}
			?>
		</li>
	</ul>
</nav>