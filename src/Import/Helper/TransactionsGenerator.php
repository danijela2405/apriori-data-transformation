<?php

namespace Import\Helper;

use Repository\AlarmRepository;

/**
 * Class TransactionsGenerator
 * @package Import\Helper
 */
class TransactionsGenerator
{
    /**
     * @var DateTimeHelper
     */
    private $dateTimeHelper;

    /**
     * @var AlarmRepository
     */
    private $alarmRepository;

    /**
     * TransactionsGenerator constructor.
     *
     * @param AlarmRepository $alarmRepository
     */
    public function __construct(AlarmRepository $alarmRepository)
    {
        $this->dateTimeHelper = new DateTimeHelper();
        $this->alarmRepository = $alarmRepository;
    }

    /**
     * generate transactions from alarm data
     */
    public function generateTransactions()
    {
        $dates = $this->alarmRepository->findTimePeriods();
        $transactionId = 1;

        foreach ($dates as $date) {

            $dayAlarms = $this->alarmRepository->findTransactionByDate($date['day']);

            foreach ($dayAlarms as $dailyAlarm) {
                $alarms = $this->alarmRepository->findTransactionByDateAndInterval($dailyAlarm);

                foreach ($alarms as $alarm) {
                    $alarm->setTransactionId($transactionId);
                    $this->alarmRepository->persistAlarm($alarm);
                }

                $this->alarmRepository->flush();
                echo "transaction no. ".$transactionId.":  ".count($alarms), " alarms\n";

                $transactionId++;
            }
        }

    }
}