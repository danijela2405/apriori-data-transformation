<?php
require_once "../bootstrap.php";

//file import
$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
$alarmFormattedRepository = new \Repository\AlarmFormattedRepository($entityManager, $entityManager->getClassMetadata(AlarmFormatted::class));

$dataFormatter = new \Helper\DataFormatter($alarmRepository, $alarmFormattedRepository);

$dataFormatter->formatData();

echo "Successfully finished formatting data.\n\n";
?>