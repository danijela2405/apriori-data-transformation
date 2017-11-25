<?php

namespace Import;

use Doctrine\ORM\EntityManager;
use Import\Factory\AlarmFactory;
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
     * Reads from .cvs, transforms the data and saves it to database
     */
    public function importCsvFileIntoDb()
    {
        $alarmsArray = $this->phpExcelHelper->getActiveSheet()->toArray();
        echo "\r\n ---------- Loaded csv into an array! ---------- \r\n\r\n";
        unset($alarmsArray[0]);

        $alarmToPersist = AlarmFactory::createAlarm();

        foreach ($alarmsArray as $row => $alarm) {

            $alarmToPersist = AlarmFactory::saveAlarm($alarm, $alarmToPersist);
            $this->entityManager->persist($alarmToPersist);

            if ($row % 64 == 0) {
                $this->entityManager->flush();
            }
        }

        $this->entityManager->flush();

        echo "Finally finished!";
    }

    /**
     * Removes existing data from database so data is not duplicated
     */
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