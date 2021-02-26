<?php

$store=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->stores;

if($_POST['url']){
	$modified_url = $_POST['url'];
}
if(isset($modified_url)){ 	
	$collection1->updateOne(array("store"=>$store),array('$set'=>array("url"=>$modified_url)));
}

if($_FILES["image"]["size"]>0){
	$modified_image = $_FILES["image"];
}
if(isset($modified_image)){ 
	$collection1->updateOne(array("store"=>$store),array('$set'=>array("image"=>new MongoDB\BSON\Binary(file_get_contents($modified_image["tmp_name"]), MongoDB\BSON\Binary::TYPE_GENERIC))));
}


if($_POST['store']){
	$modified_store = $_POST['store'];
}
if(isset($modified_store)){ 
	$collection1->updateOne(array("store"=>$store),array('$set'=>array("store"=>$modified_store)));
}

echo "<script>
window.location.href='admin_control_stores.php';
</script>";
