<?php

$store=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->stores;
$collection2 = $db->products;

$collection1->deleteMany(array("store"=>$store));
$collection2->deleteMany(array("store"=>$store));

echo "<script>
window.location.href='admin_control_stores.php';
</script>";
