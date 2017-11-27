<?php
require_once "bootstrap.php";

$import = new \Import\ImportCsv($entityManager);
$import->importCsvFileIntoDb();

$import = new \View\ViewAlarms($entityManager);
$import->getAll();