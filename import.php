<?php
require_once "bootstrap.php";

$newProductName = $argv[1];

$import = new \Import\ImportCsv();
$import->importCsvFileIntoDb();