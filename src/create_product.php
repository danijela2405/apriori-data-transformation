<?php
// create_product.php <name>
require_once "../bootstrap.php";

$newProductName = $argv[1];

$product = new Alarm();
$product->setTimestamp(new DateTime());

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . "\n";