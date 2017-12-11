<?php
require_once "../bootstrap.php";

$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$transactionsGenerator = new \Import\Helper\TransactionsGenerator($alarmRepository);

$transactionsGenerator->generateTransactions();
?>