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
		<link rel="stylesheet" type="text/css" href="profile.css?v=<?php echo time(); ?>">
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
			<i onclick="location.href = 'profile.php';" class="material-icons" style="font-size:48px;color:purple">account_circle</i>
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
		<br>
		<div class="row1">
			<h1>Επισκόπηση χρήστη</h1>
		</div>
		<div class="mainrow">
			<h2>Τα προσωπικά σας στοιχεία</h2>
			<hr>
			<?php
				require 'vendor/autoload.php';

				$m = new MongoDB\Client("mongodb://127.0.0.1/");

				$db = $m->techiteasydb;

				$collection = $db->users;
				
				$username = $_SESSION['username'];
				
				$cursor = $collection->find(array("username" => $username ));
					
				foreach ($cursor as $document){
					echo '<h4><b>Name : </b>' . $document["name"] . '</h4>';
					echo '<h4><b>Surname : </b>' . $document["surname"] . '</h4>';
					echo '<h4><b>E-mail : </b>' . $document["email"] . '</h4>';
					echo '<h4><b>Phone : </b>' . $document["phone"] . '</h4>';
					echo '<h4><b>Username : </b>' . $document["username"] . '</h4>';
				}
			?>
			<br>
			<h2>Μπορείτε να αλλάξετε τον κωδικό σας</h2>
			<form method="POST" action="profile2.php">
				<hr>
				<div class="form-group">
				  <label for="password">Password:</label>
				  <input type="password" class="form-control" pattern=".{8,}" title="Must contain 8 or more characters" id="password" name="password" required>
				</div>
				<button type="submit">Υποβολή</button>
			</form>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div class="footer">
			&copy;
			<a href="http://www.ds.unipi.gr/" target="_blank">2021 DS_UNIPI
			</a>.
			All rights reserved.
		</div>
	</body>
</html>