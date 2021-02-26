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
		<link rel="stylesheet" type="text/css" href="checkout.css?v=<?php echo time(); ?>">
		<script type="text/javascript">
		function cardOption1(){
			document.getElementById("typeCard").disabled = true;
			document.getElementById("numberCard").disabled = true;
			document.getElementById("nameCard").disabled = true;
			document.getElementById("email1").disabled = true;
			document.getElementById("password").disabled = true;
			document.getElementById("cardOptionID").style.display = "none";
			document.getElementById("PayPalOptionID").style.display = "none";
		}
		function cardOption2(){
			document.getElementById("typeCard").disabled = false;
			document.getElementById("numberCard").disabled = false;
			document.getElementById("nameCard").disabled = false;
			document.getElementById("email1").disabled = true;
			document.getElementById("password").disabled = true;
			document.getElementById("cardOptionID").style.display = "block";
			document.getElementById("PayPalOptionID").style.display = "none";
		}
		function cardOption3(){
			document.getElementById("typeCard").disabled = true;
			document.getElementById("numberCard").disabled = true;
			document.getElementById("nameCard").disabled = true;
			document.getElementById("email1").disabled = false;
			document.getElementById("password").disabled = false;
			document.getElementById("cardOptionID").style.display = "none";
			document.getElementById("PayPalOptionID").style.display = "block";
		}
		</script>
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
					$delivery_price = 0;
					$total_price = 0;
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
		</div>	
		
		<?php
			if(isset($_SESSION['username']))
			{
		?>
		<br>
		<br>
		<div class="row2">
			<h1>Τα προσωπικά σας στοιχεία</h1>
		</div>
		<div class="row3">
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
		</div>
		<br>
		<br>
		<div class="row4">
			<h2>Εισάγετε τρόπο αποστολής</h2>
			<hr>
			<?php
				echo '<form method="post" action="final_submit.php?view='.date("Y-m-d H:i:s").'">';
			?>
				<div class="form-group">
					 <label for="street">Οδός:</label>
					 <input type="street" class="form-control" pattern=".{1,}" title="Must contain only characters" id="street" name="street" required>
				</div>
				<div class="form-group">
					 <label for="streetNumber">Αριθμός οδού:</label>
					 <input type="streetNumber" class="form-control" pattern="[0-9]+" title="Must contain only numbers" id="streetNumber" name="streetNumber" required>
				</div>
				<div class="form-group">
					 <label for="area">Περιοχή:</label>
					 <input type="area" class="form-control" pattern=".{1,}" title="Must contain only characters" id="area" name="area" required>
				</div>
				<div class="form-group">
					 <label for="postcode">Ταχυδρομικός Κώδικας:</label>
					 <input type="postcode" class="form-control" pattern="[0-9]{5}" title="Must contain 5 numbers" id="postcode" name="postcode" required>
				</div>
				<br>
				<br>
				
				<h2>Επιθυμείτε πληρωμή με αντικαταβολή, με κάρτα ή μέσω PayPal;</h2>
				<hr>
				<div class="form-check">
				  <label class="form-check-label">
					<input type="radio" id="cash"  name="payment" value="cash" class="form-check-input" onclick="cardOption1()"><b>Αντικαταβολή</b>
				  </label>
				</div>
				<br>
				<div class="form-check">
				  <label class="form-check-label">
					<input type="radio" id="card"  name="payment" value="card" class="form-check-input" onclick="cardOption2()"><b>Κάρτα</b>
				  </label>
				</div>
				<br>
				<div class="form-check">
				  <label class="form-check-label">
					<input type="radio" id="paypal"  name="payment" value="paypal" class="form-check-input" onclick="cardOption3()"><b>PayPal</b>
				  </label>
				</div>
				<br>
				<br>
				<div id="cardOptionID" style="display:none">
					<div class="form-group">
					  <label for="typeCard">Τύπος κάρτας (π.χ. Visa,Mastercard):</label>
					  <input type="typeCard" class="form-control" pattern=".{1,}" title="Must contain only characters" id="typeCard" name="typeCard" required>
					</div>
					<div class="form-group">
					  <label for="numberCard">16-ψήφιος αριθμός κάρτας:</label>
					  <input type="numberCard" class="form-control" pattern="[0-9]{16}" title="Must contain 16 numbers" id="numberCard" name="numberCard" required>
					</div>
					<div class="form-group">
					  <label for="nameCard">Ονοματεπώνυμο:</label>
					  <input type="nameCard" class="form-control" pattern=".{1,}" title="Must contain only characters" id="nameCard" name="nameCard" required>
					</div>
					<br>
				</div>
				<div id="PayPalOptionID" style="display:none">
					<div class="form-group">
					  <label for="email1">E-mail:</label>
					  <input type="email1" class="form-control" pattern="[[a-zA-Z]0-9._%+-]+@[[a-zA-Z]0-9.-]+\.[[a-zA-Z]]{2,}$" title="characters followed by an @ sign, followed by more characters, and then a '.',followed by at least 2 letters from a to z" id="email1" name="email1" required>
					</div>
					<div class="form-group">
					  <label for="password">Password:</label>
					  <input type="password" class="form-control" pattern=".{8,}" title="Must contain 8 or more characters" id="password" name="password" required>
					</div>
					<br>
				</div>
				<div style="text-align:center;">
					<input type="submit" class="btn btn-primary" value="Επιβεβαίωση αγοράς" name="submit">
				</div>
			</form>
		<?php
			}
			else{
		?>
			<br>
			<div class="row4">
				<h2>Εισάγετε email και τηλέφωνο</h2>
				<hr>
				<?php
					echo '<form method="post" action="final_submit.php?view='.date("Y-m-d H:i:s").'">';
				?>
					<div class="form-group">
						 <label for="email">E-mail:</label>
						 <input type="email" class="form-control" pattern="[[a-zA-Z]0-9._%+-]+@[[a-zA-Z]0-9.-]+\.[[a-zA-Z]]{2,}$" title="characters followed by an @ sign, followed by more characters, and then a '.',followed by at least 2 letters from a to z" id="email" name="email" required>
					</div>
					<div class="form-group">
						 <label for="phone">Τηλέφωνο:</label>
						 <input type="text" class="form-control" pattern="[0-9]{10}" title="Must contain 10 numbers" id="phone" name="phone" required>
					</div>
					<br>
					<h2>Εισάγετε τρόπο αποστολής</h2>
					<hr>
					<div class="form-group">
						 <label for="street">Οδός:</label>
						 <input type="street" class="form-control" pattern=".{1,}" title="Must contain only characters" id="street" name="street" required>
					</div>
					<div class="form-group">
						 <label for="streetNumber">Αριθμός οδού:</label>
						 <input type="streetNumber" class="form-control" pattern="[0-9]+" title="Must contain only numbers" id="streetNumber" name="streetNumber" required>
					</div>
					<div class="form-group">
						 <label for="area">Περιοχή:</label>
						 <input type="area" class="form-control" pattern=".{1,}" title="Must contain only characters" id="area" name="area" required>
					</div>
					<div class="form-group">
						 <label for="postcode">Ταχυδρομικός Κώδικας:</label>
						 <input type="postcode" class="form-control" pattern="[0-9]{5}" title="Must contain 5 numbers" id="postcode" name="postcode" required>
					</div>
					<br>
					<br>
					
					<h2>Επιθυμείτε πληρωμή με αντικαταβολή, με κάρτα ή μέσω PayPal;</h2>
					<hr>
					<div class="form-check">
					  <label class="form-check-label">
						<input type="radio" id="cash"  name="payment" value="cash" class="form-check-input" onclick="cardOption1()"><b>Αντικαταβολή</b>
					  </label>
					</div>
					<br>
					<div class="form-check">
					  <label class="form-check-label">
						<input type="radio" id="card"  name="payment" value="card" class="form-check-input" onclick="cardOption2()"><b>Κάρτα</b>
					  </label>
					</div>
					<br>
					<div class="form-check">
					  <label class="form-check-label">
						<input type="radio" id="paypal"  name="payment" value="paypal" class="form-check-input" onclick="cardOption3()"><b>PayPal</b>
					  </label>
					</div>
					<br>
					<br>
					<div id="cardOptionID" style="display:none">
						<div class="form-group">
						  <label for="typeCard">Τύπος κάρτας (π.χ. Visa,Mastercard):</label>
						  <input type="typeCard" class="form-control" pattern=".{1,}" title="Must contain only characters" id="typeCard" name="typeCard" required>
						</div>
						<div class="form-group">
						  <label for="numberCard">16-ψήφιος αριθμός κάρτας:</label>
						  <input type="numberCard" class="form-control" pattern="[0-9]{16}" title="Must contain 16 numbers" id="numberCard" name="numberCard" required>
						</div>
						<div class="form-group">
						  <label for="nameCard">Ονοματεπώνυμο:</label>
						  <input type="nameCard" class="form-control" pattern=".{1,}" title="Must contain only characters" id="nameCard" name="nameCard" required>
						</div>
						<br>
					</div>
					<div id="PayPalOptionID" style="display:none">
						<div class="form-group">
						  <label for="email1">E-mail:</label>
						  <input type="email1" class="form-control" pattern="[[a-zA-Z]0-9._%+-]+@[[a-zA-Z]0-9.-]+\.[[a-zA-Z]]{2,}$" title="characters followed by an @ sign, followed by more characters, and then a '.',followed by at least 2 letters from a to z" id="email1" name="email1" required>
						</div>
						<div class="form-group">
						  <label for="password">Password:</label>
						  <input type="password" class="form-control" pattern=".{8,}" title="Must contain 8 or more characters" id="password" name="password" required>
						</div>
						<br>
					</div>
					<div style="text-align:center;">
						<input type="submit" class="btn btn-primary" value="Επιβεβαίωση αγοράς" name="submit">
					</div>
				</form>
		
		
		<?php
			}
		?>
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