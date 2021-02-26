<?php

$title=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->products;

if($_POST['price']){
	$modified_price = $_POST['price'];
}
if(isset($modified_price)){ 	
	$collection1->updateOne(array("title"=>$title),array('$set'=>array("price"=>$modified_price)));
}

if($_POST['store']){
	$modified_store = $_POST['store'];
}
if(isset($modified_store)){
	$collection1->updateOne(array("title"=>$title),array('$set'=>array("store"=>$modified_store)));
}

if($_POST['availability']){
	$modified_availability = $_POST['availability'];
}
if(isset($modified_availability)){ 
	$collection1->updateOne(array("title"=>$title),array('$set'=>array("availability"=>$modified_availability)));
}


if($_FILES["image"]["size"]>0){
	$modified_image = $_FILES["image"];
}
if(isset($modified_image)){ 
	$collection1->updateOne(array("title"=>$title),array('$set'=>array("image"=>new MongoDB\BSON\Binary(file_get_contents($modified_image["tmp_name"]), MongoDB\BSON\Binary::TYPE_GENERIC))));
}


if($_POST['title']){
	$modified_title = $_POST['title'];
}
if(isset($modified_title)){ 
	$collection1->updateOne(array("title"=>$title),array('$set'=>array("title"=>$modified_title)));
}

echo "<script>
window.location.href='admin_control_products.php';
</script>";
