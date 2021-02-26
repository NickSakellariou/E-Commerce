<?php

$title=$_GET['view'];

require 'vendor/autoload.php';

$m = new MongoDB\Client("mongodb://127.0.0.1/");

$db = $m->techiteasydb;

$collection1 = $db->products;

$collection1->deleteMany(array("title"=>$title));

echo "<script>
window.location.href='admin_control_products.php';
</script>";
?>