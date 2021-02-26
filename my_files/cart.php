<!DOCTYPE html>
<?php
session_start();

if(isset($_POST["submit"])){
	
	require 'vendor/autoload.php';

	$m = new MongoDB\Client("mongodb://127.0.0.1/");

	$db = $m->techiteasydb;

	$collection = $db->products;
	
	$products_price = 0;
	$i=1;
	
	while(1){
		if(isset($_COOKIE["name".$i])){
			
			$cursor = $collection->find(array("title" => $_COOKIE["name".$i]));
	
			foreach($cursor as $document){
				$modified_availability = $document['availability']+$_COOKIE["quantity".$i];
				$collection->updateOne(array("title"=>$_COOKIE["name".$i]),array('$set'=>array("availability"=>$modified_availability)));
			}
			
			unset($_COOKIE["name".$i]); 
			unset($_COOKIE["price".$i]); 
			unset($_COOKIE["quantity".$i]); 
			unset($_COOKIE["store".$i]); 
			setcookie("name".$i, null, -1, '/'); 
			setcookie("price".$i, null, -1, '/');
			setcookie("quantity".$i, null, -1, '/');
			setcookie("store".$i, null, -1, '/');
							
			$i++;
			continue;
		}
		else{
			break;
		}
	}
}
?>
<html>
	<head>
		<title>TechItEasy</title>
		<meta charset="UTF-8">
		<meta name="viewpoint" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="cart.css?v=<?php echo time(); ?>">
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
			<li class="nav-item active">
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
		<br>
		<div class="row1">
			<h1>Το καλάθι σας</h1>
		</div>
		<br>
		<div id="shoppingCart">
			<div id="cartItems">
				<br>
				<?php
					$products_price = 0;
					$id = 0;
					
					$i=1;
					
					while(1){
						if(isset($_COOKIE["name".$i])){
							$products_price += ($_COOKIE["price".$i]*$_COOKIE["quantity".$i]);
							echo "<h4>";
							echo $i.")";
							echo "</h4>";
							echo "<h5>";
							echo "<b>Title : </b>" .$_COOKIE["name".$i];
							echo "<br>";
							echo "<b> Price : </b>" .$_COOKIE["price".$i]. "€";
							echo "<br>";
							echo " <b>Quantity : </b>" .$_COOKIE["quantity".$i];
							echo "<br>";
							echo " <b>Store : </b>" .$_COOKIE["store".$i];
							echo "<br>";
							echo "</h5>";
							echo "<br>";
							$id = 1;
							
							$i++;
							continue;
						}
						else{
							break;
						}
					}
					
					if($id == 0){
						echo "<h4>";
						echo "<center>";
						echo "Δεν έχετε επιλέξει προϊόντα";
						echo "</center>";
						echo "</h4>";
					}
				?>
			</div>
			<br>
			<hr>
			<br>
			<?php
				echo "<h5>";
				echo "<b>Total price : </b>";
				echo $products_price . "€";
				echo "</h5>";
				echo "<br>";
			?>
			<br>
			<?php
			if($id == 1){
				?>
				<form method="POST" action="checkout.php">
					<input type="submit" class="btn btn-primary" value="Καταχώρηση στοιχείων" name="submit">		
				</form>
				<br>
				<br>
				<?php
			}
			?>
			<form method="POST">
				<input type="submit" class="btn btn-danger" value="Άδειασμα καλαθιού" name="submit">		
			</form>
		</div>	
		<br>
		<br>
		<br>
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