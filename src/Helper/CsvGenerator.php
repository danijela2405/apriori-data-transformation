<?php

namespace Helper;

use PHPExcel;
use PHPExcel_Writer_CSV;
use Repository\TransactionsFormattedRepository;
use TransactionsFormatted;

/**
 * Class CsvGenerator
 * @package Helper
 */
class CsvGenerator
{
    /**
     * @var TransactionsFormattedRepository
     */
    private $transactionsFormattedRepository;

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
    private static $iteration = 100;

    /**
     * @var int
     */
    private $columnCount = 2;

    /**
     * @var string
     */
    private $fileName = 'media/files/transactions_formatted.csv';

    /**
     * CsvGenerator constructor.
     * @param TransactionsFormattedRepository $transactionsFormattedRepository
     */
    public function __construct(TransactionsFormattedRepository $transactionsFormattedRepository)
    {
        $this->transactionsFormattedRepository = $transactionsFormattedRepository;
    }

    /**
     *
     */
    public function writeCsv()
    {
        $transactionsChunks = $this->transactionsFormattedRepository->findChunkByIds($this->startId, $this->endId);
        $this->writeTitle();

        while (!empty($transactionsChunks)) {

            $lastTime = 0;

            $time1 = microtime(true);

            $transactionsChunks = $this->writeAlarms($transactionsChunks);

            gc_collect_cycles();

            /*** - print - ***/
            $time = microtime(true) - $time1;
            echo $this->endId." transactions checked\n";
            echo "time diff from last: ".round(($time - $lastTime), 2)."\n";
            echo "time per format: ".round(($time / $this->endId), 5)."\n";
            echo "memory peak: ".round(((memory_get_peak_usage() / 1024) / 1024), 2)." mb \n\n";
            /*** - print - ***/

            $this->startId = $this->startId + self::$iteration;
            $this->endId = $this->endId + self::$iteration;
        }
        unset($transactionsChunks);
    }

    /**
     */
    private function writeTitle()
    {
        $startingColumn = 'A';
        $title = [];
        $file = fopen($this->fileName, 'w');

        for ($cameraCount = 1; $cameraCount <= 6; $cameraCount++) {
            for ($presetCount = 1; $presetCount <= 8; $presetCount++) {
                $title[] =
                    'K'.$cameraCount.'preset'.$presetCount;
                $startingColumn++;
            }
        }
        fputcsv($file, $title);
        fclose($file);
    }

    /**
     * @param $transactions
     * @return array
     */
    private function writeAlarms($transactions)
    {
        $startingColumn = 'A';
        /**
         * @var TransactionsFormatted $transaction
         */
        foreach ($transactions as $transaction) {
            $alarms = $transaction->getAlarms();
            $file = fopen($this->fileName, 'a');
            $row = [];

            if (count($alarms) == 1) {
                continue;
            }

            for ($cameraCount = 1; $cameraCount <= 6; $cameraCount++) {
                for ($presetCount = 1; $presetCount <= 8; $presetCount++) {
                    if (!in_array('K'.$cameraCount.'preset'.$presetCount, $alarms)) {
                        $row[] = false;
                    } else {
                        $row[] = true;
                    }

                    $startingColumn++;
                }
            }
            fputcsv($file, $row);

            fclose($file);
            unset($file);
            unset($alarms);

            $this->columnCount++;
        }

        unset($transactions);
        $transactionsChunks = $this->transactionsFormattedRepository->findChunkByIds($this->startId, $this->endId);

        return $transactionsChunks;
    }
}