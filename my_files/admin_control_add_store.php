<?php

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->stores;

$image = $_FILES["image"];

$store=$_POST['store'];
$url=$_POST['url'];

$document1 = array(
	"store" => $store,
	"url" => $url,
	"image" => new MongoDB\BSON\Binary(file_get_contents($image["tmp_name"]), MongoDB\BSON\Binary::TYPE_GENERIC),
);

$collection1->insertOne($document1);

echo "<script>
window.location.href='admin_control_stores.php';
</script>";

?>