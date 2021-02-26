<?php

session_start();

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->purchases;

$date=$_GET['view'];
$street=$_POST['street'];
$streetNumber=$_POST['streetNumber'];
$area=$_POST['area'];
$postcode=$_POST['postcode'];

if(isset($_SESSION['username'])){
	$username=$_SESSION['username'];
	$i=1;
	
	while(1){
		if(isset($_COOKIE[$username.$i])){
			$i++;
			continue;
		}
		else{
			setcookie($username.$i,$date,time() + 86400, "/", "", 0);
			break;
		}
	}
			
	$i=1;
	
	while(1){
		if(isset($_COOKIE["name".$i])){
			
			$document1 = array(
				"username" => $username,
				"date" => $date,
				"street" => $street,
				"streetNumber" => $streetNumber,
				"area" => $area,
				"postcode" => $postcode,		
				"product" => $_COOKIE["name".$i],
				"price" => $_COOKIE["price".$i],
				"quantity" => $_COOKIE["quantity".$i],
				"store" => $_COOKIE["store".$i],
			);
			$collection1->insertOne($document1);

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
	
	echo "<script>
	alert('Η παραγγελία πραγματοποιήθηκε με επιτυχία!');
	window.location.href='past_orders.php';
	</script>";
}
else{
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	
	$i=1;
	
	while(1){
		if(isset($_COOKIE["name".$i])){
			
			$document2 = array(
				"email" => $email,
				"phone" => $phone,
				"date" => $date,
				"street" => $street,
				"streetNumber" => $streetNumber,
				"area" => $area,
				"postcode" => $postcode,		
				"product" => $_COOKIE["name".$i],
				"price" => $_COOKIE["price".$i],
				"quantity" => $_COOKIE["quantity".$i],
			);
			
			$collection1->insertOne($document2);

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
	
	echo "<script>
	alert('Η παραγγελία πραγματοποιήθηκε με επιτυχία!');
	window.location.href='home_page.php';
	</script>";
}
?>