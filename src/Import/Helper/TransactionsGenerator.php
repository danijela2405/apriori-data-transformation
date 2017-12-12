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
     * @var AlarmRepository
     */
    private $alarmRepository;

    private $transactionId = 1;

    /**
     * TransactionsGenerator constructor.
     *
     * @param AlarmRepository $alarmRepository
     */
    public function __construct(AlarmRepository $alarmRepository)
    {
        $this->alarmRepository = $alarmRepository;
    }

    /**
     * generate transactions from alarm data
     */
    public function generateTransactions()
    {
        $dates = $this->alarmRepository->findTimePeriods();

        $dateCount = count($dates);

        $totalCount = 10;
        for ($count = 0; $count < $totalCount; $count++) {
            $this->iterateDays($dates, $dateCount, ($count / $totalCount), (($count + 1) / $totalCount));
            $this->alarmRepository->flush();
        }
    }

    private function iterateDays($dates, $dateCount, $countStart, $countEnd)
    {
        for ($count = intval($dateCount * $countStart); $count < intval($dateCount * $countEnd); $count++) {

            $dayAlarms = $this->alarmRepository->findTransactionByDate($dates[$count]['day']);
            $dayAlarmsIds = [];

            foreach ($dayAlarms as $dailyAlarm) {
                $dayAlarmsIds[] = $dailyAlarm->getId();
            }

            $this->iterateDayAlarms($dayAlarms, $dayAlarmsIds);

        }
    }

    private function iterateDayAlarms($dayAlarms, $dayAlarmsIds)
    {
        foreach ($dayAlarms as $dailyAlarm) {

            $alarms = $this->alarmRepository->findTransactionByDateAndInterval($dailyAlarm, $dayAlarmsIds);

            foreach ($alarms as $key => $alarm) {
                $this->persistAlarm($alarm);
            }

            echo "transaction no. ".$this->transactionId.":  ".count($alarms), " alarms\n";
            $this->transactionId++;

            unset($alarms);
        }
    }

    private function persistAlarm($alarm)
    {
        $alarm->addTransaction($this->transactionId);
        $this->alarmRepository->persistAlarm($alarm);
    }
}