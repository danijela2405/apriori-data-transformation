<?php

namespace Helper;

use Alarm;
use AlarmFormatted;
use Repository\AlarmRepository;
use Repository\AlarmFormattedRepository;

/**
 * Class DataFormatter
 * @package Helper
 */
class DataFormatter
{
    /**
     * @var AlarmRepository
     */
    private $alarmRepository;

    /**
     * @var AlarmFormattedRepository
     */
    private $alarmFormattedRepository;

    /**
     * @var array
     */
    private $alarmChunks;

    /**
     * @var int
     */
    private static $iteration = 1000;

    /**
     * @var int
     */
    private $endId = 1000;

    /**
     * @var int
     */
    private $startId = 1;

    /**
     * DataFormatter constructor.
     * @param AlarmRepository $alarmRepository
     * @param AlarmFormattedRepository $alarmFormattedRepository
     */
    public function __construct(AlarmRepository $alarmRepository, AlarmFormattedRepository $alarmFormattedRepository)
    {
        $this->alarmRepository = $alarmRepository;
        $this->alarmFormattedRepository = $alarmFormattedRepository;
    }

    public function formatData()
    {
        $this->alarmChunks = $this->alarmRepository->findChunkByIds($this->startId, $this->endId);

        while (!empty($this->alarmChunks)) {
            $lastTime = 0;

            $time1 = microtime(true);

            $this->iterateAlarms($this->startId, $this->endId);
            $this->alarmFormattedRepository->flush();

            gc_collect_cycles();

            /*** - print - ***/
            $time = microtime(true) - $time1;
            echo "time: ".round($time, 2).", ".$this->endId." alarms formatted\n";
            echo "time diff from last: ".round(($time - $lastTime), 2)."\n";
            echo "time per persist: ".round(($time / $this->endId), 5)."\n";
            echo "memory peak: ".round(((memory_get_peak_usage() / 1024) / 1024), 2)." mb \n\n";
            /*** - print - ***/

            $this->startId = $this->startId + self::$iteration;
            $this->endId = $this->endId + self::$iteration;

        }
    }

    private function iterateAlarms($startCount, $endCount)
    {
        for ($count = 0; $count < self::$iteration; $count++) {
            /**
             * @var Alarm $alarm
             */
            $alarm = $this->alarmChunks[$count];
            $transactions = $alarm->getTransactions();
            if (!empty($transactions)) {
                foreach ($transactions as $transactionId) {
                    $formattedAlarm = new AlarmFormatted();
                    $formattedAlarm->setTime($alarm->getTime());
                    $formattedAlarm->setDate($alarm->getDate());
                    $formattedAlarm->setPresetName($alarm->getPresetName());
                    $formattedAlarm->setLogicCameraId($alarm->getLogicCameraId());
                    $formattedAlarm->setCameraId($alarm->getCameraId());
                    $formattedAlarm->setCameraPosition($alarm->getCameraPosition());
                    $formattedAlarm->setTransactionId($transactionId);

                    $this->alarmFormattedRepository->persistFormattedAlarm($formattedAlarm);
                }
            }
            $this->alarmChunks = $this->alarmRepository->findChunkByIds($startCount - 1, $endCount);

        }
    }
}