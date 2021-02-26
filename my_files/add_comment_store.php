<?php

session_start();

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->comments;

$store=$_GET['view'];

$comment=$_POST['comment'];
$rating=$_POST['rating'];

if(isset($_SESSION['username'])){
	$document1 = array(
		"product" => $store,
		"comment" => $comment,
		"rating" => $rating,
		"username" => $_SESSION['username'],
	);

$collection1->insertOne($document1);
}
else{
	$username=$_POST['username'];
	
	$collection10 = $db->users;
	
	$criteria10 = array(
		"username" => $_POST['username'] ,
	);
	
	$doc10 = $collection10->findOne($criteria10);
	if(!empty($doc10)) {
		echo "<script>
		alert('This username exists to someone else');
		window.location.href='stores.php';
		</script>";
	}
	else{
	
	$criteria = array(
		"username" => $_POST['username'] ,
		"product"=>$store,
	);
				
	$doc = $collection1->findOne($criteria);
				
	if(!empty($doc)) {
		echo "<script>
		alert('This username already commented,try something else');
		window.location.href='stores.php';
		</script>";
	}
	else{
		$document2 = array(
		"product" => $store,
		"comment" => $comment,
		"rating" => $rating,
		"username" => $username,
	);

	$collection1->insertOne($document2);
	}
	}
}

echo "<script>
window.location.href='stores.php';
</script>";

?>