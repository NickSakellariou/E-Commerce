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
		<link rel="stylesheet" type="text/css" href="admin_control_stores.css?v=<?php echo time(); ?>">
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
					echo '<form action="admin_control_add_store.php" method="post" enctype="multipart/form-data">';
						echo '<label for="title" ><b> ADD A STORE <b></label>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="store" placeholder="Name of store" required>';
						echo '<br>';
						echo '<br>';
						echo '<input type="text" name="url" placeholder="URL of store" required>';
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

			$collection = $db->stores;
			
			$cursor = $collection->find();
	
			foreach($cursor as $document){
				echo '<div class="row2">';
					echo '<div>';
						echo '<br>';
						echo '<a href=' . $document["url"] . '>';
							echo '<img src="data:image/jpeg;base64,'.base64_encode( $document['image'] ).'"/>';
						echo '<a>';
						echo '<br>';
						echo '<br>';
						echo '<a href=' . $document["url"] . '>';
							echo '<h4 style="color:black;"><b>Store : </b>' . $document["store"] . '</h4>';
						echo '<a>';
						echo '<form action="admin_control_edit_store.php?view='.$document["store"].'" method="post" enctype="multipart/form-data">';
							echo '<br>';
							echo '<label for="title" ><b> EDIT THE STORE <b></label>';
							echo '<br>';
							echo '<input type="text" name="store" placeholder="New title of store">';
							echo '<br>';
							echo '<input type="text" name="url" placeholder="New url of store">';
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
						echo '<a class="btn btn-danger" href="admin_control_remove_store.php?view='.$document["store"].'">';
							echo 'Αφαίρεση';
						echo '</a>';
					echo '</div>';
				echo '</div>';
				echo '<br>';
			echo '<br><br>';
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