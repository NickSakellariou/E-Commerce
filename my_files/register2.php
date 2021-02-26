<?php
session_start();

$name=$_POST['name'];
$surname=$_POST['surname'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$username=$_POST['username'];
$password=$_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->users;

$criteria = array(
		"username" => $username ,
	);
	
$doc = $collection1->findOne($criteria);


if(!empty($doc)) {
	echo "<script>
	alert('This username already exists,try something else');
	window.location.href='register.html';
	</script>";
} else {
	
	$document1 = array(
		"name" => $name,
		"surname" => $surname,
		"email" => $email,
		"phone" => $phone,
		"username" => $username,
		"password" => $hashed_password,
	);
	$collection1->insertOne($document1);
	
	$_SESSION["username"] = $username;
	
	echo "<script>
	alert('Ο χρήστης: $username δημιουργήθηκε με επιτυχία!');
	window.location.href='home_page.php';
	</script>";
}
?>