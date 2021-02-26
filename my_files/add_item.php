<?php

$quantity=$_POST['quantity'];

$title=$_GET['view'];
$price=$_GET['view2'];
$store=$_GET['view3'];

$i=1;

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection = $db->products;

$cursor = $collection->find(array("title" => $title));
	
foreach($cursor as $document){
	$modified_availability = $document['availability']-$quantity;
	$collection->updateOne(array("title"=>$title),array('$set'=>array("availability"=>$modified_availability)));
}

while(1){
	if(isset($_COOKIE["name".$i])){
		$i++;
		continue;
	}
	else{
		setcookie("name".$i,$title,time() + 86400, "/", "", 0);
		setcookie("price".$i,$price,time() + 86400, "/", "", 0);
		setcookie("quantity".$i,$quantity,time() + 86400, "/", "", 0);
		setcookie("store".$i,$store,time() + 86400, "/", "", 0);
		echo "<script>
		window.location.href='cart.php';
		</script>";
	}
}

?>