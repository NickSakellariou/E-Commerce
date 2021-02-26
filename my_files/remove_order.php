<?php

session_start();

$date=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->purchases;
$collection2 = $db->products;

$cursor1 = $collection1->find(array("username" => $_SESSION['username']));
	
foreach($cursor1 as $document1){
	
	$title = $document1['product'];
	$quantity = $document1['quantity'];
	$cursor2 = $collection2->find(array("title" => $title));
	
	foreach($cursor2 as $document2){
		$modified_availability = $document2['availability']+$quantity;
		$collection2->updateOne(array("title"=>$title),array('$set'=>array("availability"=>$modified_availability)));
	}
}

$collection1->deleteMany(array("username"=>$_SESSION['username'],"date"=>$date,));

$k=1;

while(1){
	if(isset($_COOKIE[$_SESSION['username'].$k])){
		if($_COOKIE[$_SESSION['username'].$k] == $date){
			unset($_COOKIE[$_SESSION['username'].$k]); 
			setcookie($_SESSION['username'].$k, null, -1, '/'); 
			break;
		}
		else{
			$k++;
			continue;
		}
	}
	else{
		break;
	}
}

echo "<script>
	alert('Η παραγγελία ακυρώθηκε');
	window.location.href='past_orders.php';
	</script>"
?>