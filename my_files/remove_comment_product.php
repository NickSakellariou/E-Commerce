<?php

session_start();

$product=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->comments;

$collection1->deleteMany(array("product"=>$product,"username"=>$_SESSION['username'],));

echo "<script>
window.location.href='categories.php';
</script>";
?>