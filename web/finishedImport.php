<?php
require_once "../bootstrap.php";

$alarmRepository = new \Repository\AlarmRepository($entityManager, $entityManager->getClassMetadata(Alarm::class));
if (isset($_POST['csv'])) {
    $file = $_POST['csv'];
    $alarmRepository->importCsv($file, $connectionParams);
}

?>

<html>
<head>
    <title>Import .csv file to db</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>
<body>
<div style="padding: 10%">
    <h1> CSV to Mysql </h1>
    <div id="finishedImport">
        <h3>Successfully imported!</h3>
    </div>
</div>
</body>
</html>
