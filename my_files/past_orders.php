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
		<link rel="stylesheet" type="text/css" href="past_orders.css?v=<?php echo time(); ?>">
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
			<li class="nav-item active">
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
		<br>
		<div class="row1">
			<h1>Το ιστορικό των παραγγελιών σας</h1>
		</div>
		<br>
		<br>
		<?php
		if(isset($_SESSION['username']))
		{
			require 'vendor/autoload.php';
			
			$m = new MongoDB\Client("mongodb://127.0.0.1/");

			$db = $m->techiteasydb;
			
			$collection1 = $db->purchases;
					
			$cursor1 = $collection1->find(array("username"=>$_SESSION['username']));
			
			$j=1;
			foreach($cursor1 as $document1){
				if($j != 1){
					if($document1["date"] == $document2["date"]){
						continue;
					}
				}
				$cursor2 = $collection1->find(array("date"=>$document1['date']));
				echo '<div class="row2">';
					echo '<h2><b>Date : </b>' . $document1["date"] . '</h2>';
				echo '</div>';
				$i=1;
				echo '<div id="order">';
					echo '<div id="orderItems">';	
						$products_price = 0;
						foreach($cursor2 as $document2){
							$products_price += ($document2["price"]*$document2["quantity"]);
							echo '<br>';
							echo "<h3><b>";
							echo $i.")";
							echo "</b></h3>";
							echo '<h4><b>Product : </b>' . $document2["product"] . '</h4>';
							echo '<h4><b>Price : </b>' . $document2["price"] . ' €</h4>';
							echo '<h4><b>Quantity : </b>' . $document2["quantity"] . '</h4>';
							echo '<h4><b>Store : </b>' . $document2["store"] . '</h4>';
							$street = $document2["street"];
							$streetNumber = $document2["streetNumber"];
							$area = $document2["area"];
							$postcode = $document2["postcode"];
							$i++;
						}
						echo '<br>';
						echo '<br>';
						echo '<h3><b>Διεύθυνση αποστολής : </b></h3>';
						echo '<br>';
						echo '<h4><b>Street : </b>' . $street . '</h4>';
						echo '<h4><b>Street number : </b>' . $streetNumber . '</h4>';
						echo '<h4><b>Area : </b>' . $area . '</h4>';
						echo '<h4><b>Post code : </b>' . $postcode . '</h4>';
						echo '<br>';
						echo '<br>';
						echo "<h2 style='text-align:center;'>";
						echo "<b>Total price : </b>";
						echo $products_price . "€";
						echo "</h2>";
						echo "<br>";
						
						$k=1;
	
						while(1){
							if(isset($_COOKIE[$_SESSION['username'].$k])){
								if($_COOKIE[$_SESSION['username'].$k] == $document2["date"]){
									echo '<form method="post" action="remove_order.php?view='.$document2["date"].'" style="text-align:center;">';
										echo '<input type="submit" class="btn btn-danger" value="Ακύρωση παραγγελίας" name="submit">';		
									echo '</form>';
									echo '<br>';
									break;
								}
								else{
									$k++;
									continue;
								}
							}
							else{
								$k++;
								continue;
							}
						}
					echo '</div>';
				echo '</div>';	
				echo '<br>';
				echo '<br>';
				$j++;
			}
		?>
		<?php
			}
			else{
				echo '<div id="order">';
					echo '<div id="orderItems" style="text-align:center;">';
						echo '<h2>Δεν έχετε συνδεθεί!</h2>';
					echo '</div>';
				echo '</div>';	
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
			}
		?>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
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