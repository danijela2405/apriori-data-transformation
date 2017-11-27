<?php

namespace View;

use Doctrine\ORM\EntityManager;
use Import\Factory\AlarmFactory;
use Import\Helper\PhpExcelHelper;

/**
 * Class ImportCsv
 * @package Import
 */
class ViewAlarms
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ViewAlarms constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Reads from .cvs, transforms the data and saves it to database
     */
    public function getAll()
    {
        $alarmRepository = $this->entityManager->getRepository('Alarm');
        $alarms = $alarmRepository->findAll();

        echo "\r\nTotal alarms in db: ".count($alarms)."\r\n\r\n";

    }
}