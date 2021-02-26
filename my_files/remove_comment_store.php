<?php

session_start();

$store=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->comments;

$collection1->deleteMany(array("product"=>$store,"username"=>$_SESSION['username'],));

echo "<script>
window.location.href='stores.php';
</script>";
?>