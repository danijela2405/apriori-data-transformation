<?php

namespace Helper;

use Alarm;
use Repository\AlarmRepository;

/**
 * Class TransactionsGenerator
 * @package Helper
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

        $totalCount = 100;

        $lastTime = $lastTransactions = 0;
        for ($count = 0; $count < $totalCount; $count++) {
            $time1 = microtime(true);

            $this->iterateDays($dates, $dateCount, ($count / $totalCount), (($count + 1) / $totalCount));
            $this->alarmRepository->flush();

            gc_collect_cycles();
            $time = microtime(true) - $time1;
            echo "time: ".round($time,2).", ".$this->transactionId." transactions\n";
            echo "time diff from last: ".round(($time-$lastTime),2).", ".($this->transactionId -$lastTransactions)." diff transactions\n";
            echo "time per transaction: ".round(($time/($this->transactionId -$lastTransactions)),5)."\n";
            echo "memory peak: ".round(((memory_get_peak_usage()/1024)/1024),2)." mb \n\n";
            $lastTime = $time;
            $lastTransactions = $this->transactionId;
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

            $this->transactionId++;

            unset($alarms);
        }
    }

    private function persistAlarm(Alarm $alarm)
    {
        $alarm->addTransaction($this->transactionId);
        $this->alarmRepository->persistAlarm($alarm);
    }
}