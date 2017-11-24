<?php

namespace Import;

use Doctrine\ORM\EntityManager;
use Import\Helper\PhpExcelHelper;

/**
 * Class ImportCsv
 * @package Import
 */
class ImportCsv
{
    /**
     * @var PhpExcelHelper
     */
    private $phpExcelHelper;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ImportCsv constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->removeExistingAlarmsFromDb();
        $this->phpExcelHelper = new PhpExcelHelper();
    }

    /**
     *
     */
    public function importCsvFileIntoDb()
    {
        $rowCount = $this->phpExcelHelper->getRowCount();

        for ($row = 2; $row <= $rowCount; $row++) {

            $alarm = $this->phpExcelHelper->saveAlarm($row);
            $this->entityManager->persist($alarm);

            unset($alarm);
            echo "Importing alarm no. ".($row-1)."\r\n";

            if($row%50 == 0){
                $this->entityManager->flush();
            }
        }

        $this->entityManager->flush();
    }

    private function removeExistingAlarmsFromDb()
    {
        $alarmRepository = $this->entityManager->getRepository('Alarm');
        $alarms = $alarmRepository->findAll();

        echo "Deleting previous imports...\r\n";

        foreach ($alarms as $alarm) {
            $this->entityManager->remove($alarm);
            echo ".";
        }

        echo "\r\n";

        $this->entityManager->flush();

        echo "Finished deleting previous imports!\r\n";
    }
}