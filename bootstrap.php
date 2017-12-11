<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$config = new \Doctrine\DBAL\Configuration();
$connectionParams = array(
    'dbname' => 'apriori-transformation',
    'port' => '8000',
    'user' => 'root',
    'password' => 'root',
    'host' => 'localhost',
    'driver' => 'pdo_mysql'
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

$paths = array(__DIR__."/config/xml");
$isDevMode = true;

$config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($connectionParams, $config);