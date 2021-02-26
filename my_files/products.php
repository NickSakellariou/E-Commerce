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
		<link rel="stylesheet" type="text/css" href="products.css?v=<?php echo time(); ?>">
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
			<li class="nav-item active">
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
			<?php
			if(isset($_SESSION['username']))
			{
			?>
			<i onclick="location.href = 'profile.php';" class="material-icons" style="font-size:48px;color:purple">account_circle</i>
			<div class="logout">
				<form action="logout.php"><input type="submit" class="btn btn-danger" value="LogOut"></form>
			</div>
			<?php
			}
			else if(isset($_SESSION['admin']))
			{
			?>
			<i onclick="location.href = 'admin_control.php';" class="material-icons" style="font-size:48px;color:purple">account_circle</i>
			<div class="logout">
				<form action="logout.php"><input type="submit" class="btn btn-danger" value="LogOut"></form>
			</div>
			<?php
			}	
			else{
			?>
			<i onclick="document.getElementById('id01').style.display='block'" class="material-icons" style="font-size:48px">account_circle</i>
			<?php
			}
			?>
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
				<h1>Επιλέξτε τα προϊόντα που σας ενδιαφέρουν</h1>
			</div>
			<br>
			<br>
			<?php
			require 'vendor/autoload.php';
			
			$category=$_GET['view'];

			$m = new MongoDB\Client("mongodb://127.0.0.1/");

			$db = $m->techiteasydb;

			$collection = $db->products;
			
			$cursor = $collection->find(array("category" => $category));
	
			foreach($cursor as $document){
				if($document["availability"] == 0){
					continue;
				}
				echo '<div id="row2">';
					echo '<div>';
						echo '<img src="data:image/jpeg;base64,'.base64_encode( $document['image'] ).'"/>';
						echo '<br>';
						echo '<br>';
						echo '<h4>' . $document["title"] . '</h4>';
							
						echo '<form action="add_item.php?view='.$document["title"].'&view2='.$document["price"].'&view3='.$document["store"].'" method="post">';
						echo '<br>';
							echo '<label class="container2">' . $document["price"] . '€';
								echo '<input type="checkbox" name="check" required>';
								echo '<span class="checkmark"></span>';
							echo '</label>';
							echo '<br>';
							echo '<br>';
							echo '<h5>Εταιρεία : ' . $document["store"] . '</h5>';
							echo '<br>';
							echo '<h5>Διαθεσιμότητα : ' . $document["availability"] . ' items </h5>';
							echo '<br>';
							if($document["availability"] == 1){
								echo '<label for="quantity" > Quantity (only one left):</label>';
								echo '<input type="number" id="quantity" name="quantity"  min="1" max='.$document["availability"].' required>';
							}
							else{
								echo '<label for="quantity" > Quantity (between 1 and '.$document["availability"].'):</label>';
								echo '<input type="number" id="quantity" name="quantity"  min="1" max='.$document["availability"].' required>';
							}
							echo '<br>';
							echo '<br>';
							echo '<a href = product.php?view='.$document["price"].'&view2='.$category.'&view3='.$document["store"].'>';
								echo '<h4>Σχόλια χρηστών</h4>';
							echo '<a>';
							echo '<br>';
							echo '<br>';
							echo '<input type="submit" class="btn btn-primary" value="Add to cart" >';
						echo '</form>';
					echo '</div>';
				echo '</div>';
				echo '<br>';
			echo '<br><br>';
			}
			?>			
			<br>
			<br>
			<br>
		</div>
		<div id="id01" class="modal">
		  
		  <form class="modal-content animate" action="login.php" method="post">
			<div class="container">
			  <label for="uname"><b>Username</b></label>
			  <input type="text" placeholder="Enter Username" pattern=".{5,}" title="Must contain 5 or more characters" name="username" required>

			  <label for="psw"><b>Password</b></label>
			  <input type="password" placeholder="Enter Password" pattern=".{8,}" title="Must contain 8 or more characters" name="password" required>
				
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