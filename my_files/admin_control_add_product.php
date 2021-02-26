<?php

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->products;

$image = $_FILES["image"];

$title=$_POST['title'];
$price=$_POST['price'];
$store=$_POST['store'];
$category=$_POST['category'];
$availability=$_POST['availability'];

$document1 = array(
	"title" => $title,
	"price" => $price,
	"image" => new MongoDB\BSON\Binary(file_get_contents($image["tmp_name"]), MongoDB\BSON\Binary::TYPE_GENERIC),
	"store" => $store,
	"category" => $category,
	"availability" => $availability,
);

$collection1->insertOne($document1);

echo "<script>
window.location.href='admin_control_products.php';
</script>";

?>