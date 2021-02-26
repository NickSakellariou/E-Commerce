<!DOCTYPE html>
<?php
session_start();
?>
<html>
	<head>
		<title>TechItEasy</title>
		<meta charset="UTF-8">
		<meta name="viewpoint" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="admin_control.css?v=<?php echo time(); ?>">
	</head>
	<body>
		<div class="header">
			<a href="home_page.php">
				<h1>
					<img src="icons/logo.jpeg">
						TechItEasy
				</h1>
			</a>
			<h5>All about electronics</h5>
			<br>
			<br>
			<h3>Πάντα δίπλα στον πελάτη με ποιοτικές λύσεις τεχνολογίας!!!</h3>	
		</div>
		<nav class="navbar navbar-expand-sm bg-info navbar-dark">
		  <ul class="navbar-nav">
			<li class="nav-item">
			  <a class="nav-link" href="home_page.php">ΑΡΧΙΚΗ</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="categories.php">ΚΑΤΗΓΟΡΙΕΣ</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="stores.php">ΕΤΑΙΡΕΙΑ</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="faq.php">F.A.Q.</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="cart.php">ΚΑΛΑΘΙ</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="past_orders.php">ΙΣΤΟΡΙΚΟ</a>
			</li>
			<i onclick="location.href = 'admin_control.php';" class="material-icons" style="font-size:48px;color:purple">account_circle</i>
			<div class="logout">
				<form action="logout.php"><input type="submit" class="btn btn-danger" value="LogOut"></form>
			</div>
		  </ul>
		  <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<form class="search" action="search.php" method="post">
					  <input type="text" placeholder="Search.." name="search">
					  <button type="submit" style="font-size:1px"><i class="material-icons">search</i></button>
					</form>
				</li>
			</ul>
		   </div>
		</nav>
		<div class="mainrow">
			<br>
			<br>
			<br>
			<div class="row1">
				<h1>Επιλέξτε μία κατηγορία</h1>
			</div>
			<br>
			<br>
			<br>
			<div class="row2">
				<a href="admin_control_statistics.php">
					<h2>Statistics of marketplace</h2>
				</a>
			</div>
			<br>
			<br>
			<div class="row2">
				<a href="admin_control_stores.php">
					<h2>Επεξεργασία καταστημάτων</h2>
				</a>
			</div>
			<br>
			<br>
			<div class="row2">
				<a href="admin_control_products.php">
					<h2>Επεξεργασία προϊόντων</h2>
				</a>
			</div>
		</div>
		<div id="id01" class="modal">
		  
		  <form class="modal-content animate" action="login.php" method="post">
			<div class="container">
			  <label for="uname"><b>Username</b></label>
			  <input type="text" placeholder="Enter Username" name="username" required>

			  <label for="psw"><b>Password</b></label>
			  <input type="password" placeholder="Enter Password" name="password" required>
				
			  <button type="submit">Login</button>
			</div>

			<div class="container" style="background-color:#f1f1f1">
			  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
			  <span class="psw">Για να συνδεθείτε πρέπει να κάνετε <a href="register.html">εγγραφή</a></span>
			</div>
		  </form>
		</div>

		<script>
		var modal = document.getElementById('id01');

		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
		</script>
		<div class="footer">
			&copy;
			<a href="http://www.ds.unipi.gr/" target="_blank">2021 DS_UNIPI
			</a>.
			All rights reserved.
		</div>
	</body>
</html>