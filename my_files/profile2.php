<?php
session_start();

$password=$_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->users;

$username = $_SESSION['username'];
$collection1->updateOne(array("username"=>$username),array('$set'=>array("password"=>$hashed_password)));
	
echo "<script>
alert('Ο κωδικός άλλαξε με επιτυχία!');
window.location.href='profile.php';
</script>";
?>