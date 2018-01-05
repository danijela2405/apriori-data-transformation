<?php
require_once "../bootstrap.php";

//file import
$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$file = 'alarms.csv';
$alarmRepository->importCsv($file, $connectionParams);

echo "Successfully finished cvs import.\n\n";

$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$transactionsGenerator = new \Import\Helper\TransactionsGenerator($alarmRepository);

$transactionsGenerator->generateTransactions();

echo "Successfully finished generating transactions.\n\n";
?>