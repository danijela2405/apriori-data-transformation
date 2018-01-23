<?php
require_once "../bootstrap.php";

//file import
$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$file = 'media/files/alarms.csv';
/*$alarmRepository->importCsv($file, $connectionParams);

echo "Successfully finished cvs import.\n\n";

//generation of transactions + saving to alarm table
$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$transactionsGenerator = new \Helper\TransactionsGenerator($alarmRepository);

$transactionsGenerator->generateTransactions();

echo "Successfully finished generating transactions.\n\n";

//reformatting of alarms and transactions + saving to transactions_formatted table*/
$transactionFormattedRepository = new \Repository\TransactionsFormattedRepository($entityManager, $entityManager->getClassMetadata(TransactionsFormatted::class));
$transactionFormatter = new \Helper\TransactionsFormatter($alarmRepository, $transactionFormattedRepository);

$transactionFormatter->formatTransactions();

echo "Successfully finished formatting data.\n\n";

//format and generation of .csv file
$csvGenerator = new \Helper\CsvGenerator($transactionFormattedRepository);

$csvGenerator->writeCsv();

echo "Successfully finished exporting csv.\n\n";

?>