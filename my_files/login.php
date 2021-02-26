<?php
session_start();

$username=$_POST['username'];
$password=$_POST['password'];

$string = "admin";

if (strcmp($username, $string) == 0 && strcmp($password, $string) == 0) {
	$_SESSION["admin"] = $string;
	echo "<script>
	window.location.href='admin_control.php';
	</script>";
}

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection = $db->users;

$criteria = array(
	"username" => $username ,
);
$doc = $collection->findOne($criteria);

if(!empty($doc)) {
	$cursor = $collection->find(array("username" => $username));
	
	foreach ($cursor as $document){
		
		if(password_verify($password, $document["password"])){
			$_SESSION["username"] = $username;
			echo "<script>
			window.location.href='profile.php';
			</script>";
		}
		else {
			echo "<script>
			alert('Username and password do not match,try again');
			window.location.href='home_page.php';
			</script>";
		}
	}
	
} else {
	echo "<script>
	alert('Username and password do not match,try again');
	window.location.href='home_page.php';
	</script>";
}
?>