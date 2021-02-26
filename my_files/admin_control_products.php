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
		<link rel="stylesheet" type="text/css" href="admin_control_products.css?v=<?php echo time(); ?>">
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
		<br>
		<br>
		<br>
		
		<?php
			echo '<div class="row1">';
				echo '<div>';
					echo '<form action="admin_control_add_product.php" method="post" enctype="multipart/form-data">';
						echo '<label for="title" ><b> ADD A PRODUCT <b></label>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="title" placeholder="Title of product" required>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="price" placeholder="Price of product" required>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="store" placeholder="Store of product" required>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="category" placeholder="Category of product" required>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="availability" placeholder="Availability of product" required>';
						echo '<br>';
						echo '<br>';
						echo '<label for="image" ><b> Image <b></label>';
						echo '<br>';
						echo '<input type="file" name="image" id="image" required>';
						echo '<br>';
						echo '<br>';
						echo '<input type="submit" class="btn btn-primary" value="Προσθήκη">';
					echo '</form>';
				echo '</div>';
			echo '</div>';
			echo '<br><br>';
			
			require 'vendor/autoload.php';
			
			$m = new MongoDB\Client("mongodb://127.0.0.1/");

			$db = $m->techiteasydb;
			
			$collection1 = $db->categories;
			
			$cursor1 = $collection1->find();
			
			echo '<br>';
			echo '<br>';
			foreach($cursor1 as $document1){
				echo '<div class="row2">';
					echo '<h1>'. $document1['category']. '</h1>';
				echo '</div>';
				echo '<br>';
				echo '<br>';
				$collection2 = $db->products;
				
				$cursor2 = $collection2->find(array("category"=>$document1['category']));
				
				foreach($cursor2 as $document2){
					echo '<div class="row3">';
						echo '<div>';			
							echo '<img src="data:image/jpeg;base64,'.base64_encode( $document2['image'] ).'"/>';
							echo '<h4><b>Product : </b>' . $document2["title"] . '</h4>';
							echo '<br>';
							echo '<h4><b>Price : </b>' . $document2["price"] . ' €</h4>';
							echo '<br>';
							echo '<h4><b>Store : </b>' . $document2["store"] . '</h4>';
							echo '<br>';
							echo '<h4><b>Availability : </b>' . $document2["availability"] . ' items </h4>';
							echo '<br>';
							echo '<h4><b>Category : </b>' . $document2["category"] . '</h4>';
							echo '<form action="admin_control_edit_product.php?view='.$document2["title"].'" method="post" enctype="multipart/form-data">';
							
							echo '<br>';
							echo '<label for="title" ><b> EDIT THE PRODUCT <b></label>';
							echo '<br>';
							echo '<input type="text" name="title" placeholder="New title of product">';
							echo '<br>';
							echo '<input type="text" name="store" placeholder="New store of product">';
							echo '<br>';
							echo '<input type="text" name="availability" placeholder="New availability of product">';
							echo '<br>';
							echo '<input type="text" name="price" placeholder="New price of product">';
							echo '<br>';
							echo '<label for="image" ><b> New image <b></label>';
							echo '<br>';
							echo '<input type="file" name="image" id="image">';
							echo '<br>';
							echo '<br>';
							echo '<input type="submit" class="btn btn-primary" value="Edit">';
						echo '</form>';
						echo '<br>';
						echo '<br>';
						echo '<a class="btn btn-danger" href="admin_control_remove_product.php?view='.$document2["title"].'">';
							echo 'Αφαίρεση';
						echo '</a>';
						echo '</div>';
					echo '</div>';
					echo '<br>';
					echo '<br><br>';
				}
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