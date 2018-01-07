<?php
require_once "../bootstrap.php";

//file import
$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$file = 'alarms-test.csv';
$alarmRepository->importCsv($file, $connectionParams);

echo "Successfully finished cvs import.\n\n";

$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$transactionsGenerator = new \Helper\TransactionsGenerator($alarmRepository);

$transactionsGenerator->generateTransactions();

echo "Successfully finished generating transactions.\n\n";

$alarmFormattedRepository = new \Repository\AlarmFormattedRepository($entityManager, $entityManager->getClassMetadata(AlarmFormatted::class));

$dataFormatter = new \Helper\DataFormatter($alarmRepository, $alarmFormattedRepository);

$dataFormatter->formatData();

echo "Successfully finished formatting data.\n\n";

?>