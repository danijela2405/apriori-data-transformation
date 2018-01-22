<?php

namespace Helper;

use Alarm;
use Repository\AlarmRepository;
use Repository\TransactionsFormattedRepository;
use TransactionsFormatted;

/**
 * Class TransactionsFormatter
 * @package Helper
 */
class TransactionsFormatter
{
    /**
     * @var AlarmRepository
     */
    private $alarmRepository;

    /**
     * @var TransactionsFormattedRepository
     */
    private $transactionsFormattedRepository;

    /**
     * @var array
     */
    private $alarmChunks;

    /**
     * @var int
     */
    private static $iteration = 100;

    /**
     * @var int
     */
    private $endId = 100;

    /**
     * @var int
     */
    private $startId = 1;

    /**
     * @var int
     */
    private $persisted = 0;

    /**
     * TransactionsFormatter constructor.
     * @param AlarmRepository $alarmRepository
     * @param TransactionsFormattedRepository $transactionsFormattedRepository
     */
    public function __construct(
        AlarmRepository $alarmRepository,
        TransactionsFormattedRepository $transactionsFormattedRepository
    ) {
        $this->alarmRepository = $alarmRepository;
        $this->transactionsFormattedRepository = $transactionsFormattedRepository;
    }


    public function formatTransactions()
    {
        $this->alarmChunks = $this->alarmRepository->findChunkByIds($this->startId, $this->endId);

        while (!empty($this->alarmChunks)) {
            $lastTime = 0;

            $time1 = microtime(true);

            $this->iterateAlarms($this->startId, $this->endId);
            $this->transactionsFormattedRepository->flush();

            gc_collect_cycles();

            /*** - print - ***/
            $time = microtime(true) - $time1;
            echo $this->endId." alarms checked\n";
            echo "time: ".round($time, 2).", ".$this->persisted." formatted alarms persisted\n";
            echo "time diff from last: ".round(($time - $lastTime), 2)."\n";
            echo "time per persist: ".round(($time / $this->endId), 5)."\n";
            echo "memory peak: ".round(((memory_get_peak_usage() / 1024) / 1024), 2)." mb \n\n";
            /*** - print - ***/

            $this->startId = $this->startId + self::$iteration;
            $this->endId = $this->endId + self::$iteration;
            $this->persisted = 0;
        }
    }

    private function iterateAlarms($startCount, $endCount)
    {
        for ($count = 0; $count < self::$iteration; $count++) {

            if (!isset($this->alarmChunks[$count])) {
                break;
            }
            /**
             * @var Alarm $alarm
             */
            $alarm = $this->alarmChunks[$count];
            $transactions = $alarm->getTransactions();
            if (!empty($transactions)) {
                foreach ($transactions as $transactionId) {
                    $transactionsFormatted = $this->transactionsFormattedRepository->findOneById($transactionId);

                    if (is_null($transactionsFormatted)) {
                        $transactionsFormatted = new TransactionsFormatted();
                        $transactionsFormatted->setTransactionId($transactionId);
                    }

                    $transactionsFormatted->addAlarm(
                        "K".$alarm->getCameraId().$alarm->getPresetName()
                    );

                    $currentAlarmCount = $transactionsFormatted->getAlarmCount();
                    $currentAlarmCount++;
                    $transactionsFormatted->setAlarmCount($currentAlarmCount);


                    $this->transactionsFormattedRepository->persistEntity($transactionsFormatted);
                    $this->persisted++;
                }
            }
            $this->alarmChunks = $this->alarmRepository->findChunkByIds($startCount - 1, $endCount);
        }
    }
}