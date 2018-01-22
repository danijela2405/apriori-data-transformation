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
     * @var PHPExcel
     */
    private $objPHPExcel;

    /**
     * @var int
     */
    private $columnCount = 2;

    /**
     * CsvGenerator constructor.
     * @param TransactionsFormattedRepository $transactionsFormattedRepository
     */
    public function __construct(TransactionsFormattedRepository $transactionsFormattedRepository)
    {
        $this->transactionsFormattedRepository = $transactionsFormattedRepository;
        $this->createPhpExcelObject();
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
            $objWriter = new PHPExcel_Writer_CSV($this->objPHPExcel);
            $objWriter->save('media/files/transactions_formatted.csv');
    }

    /**
     *
     */
    private function writeTitle()
    {
        $startingColumn = 'A';

        for ($cameraCount = 1; $cameraCount <= 6; $cameraCount++) {
            for ($presetCount = 1; $presetCount <= 8; $presetCount++) {
                $this->objPHPExcel->getActiveSheet()->SetCellValue(
                    $startingColumn."1",
                    'K'.$cameraCount.'preset'.$presetCount
                );
                $startingColumn++;
            }
        }
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

            if (count($alarms) == 1) {
                continue;
            }

            for ($cameraCount = 1; $cameraCount <= 6; $cameraCount++) {
                for ($presetCount = 1; $presetCount <= 8; $presetCount++) {
                    if (!in_array('K'.$cameraCount.'preset'.$presetCount, $alarms)) {
                        $this->objPHPExcel->getActiveSheet()->SetCellValue(
                            $startingColumn.$this->columnCount,
                            0
                        );
                    } else {
                        $this->objPHPExcel->getActiveSheet()->SetCellValue(
                            $startingColumn.$this->columnCount,
                            1
                        );
                    }

                    $startingColumn++;
                }
            }

            $this->columnCount++;
        }

        $transactionsChunks = $this->transactionsFormattedRepository->findChunkByIds($this->startId, $this->endId);

        return $transactionsChunks;
    }

    /**
     * todo:1.- First lines of the script I create the xls file and setup some header rows (the first row).
    2.- Write and Close the file by using $objPHPExcel->disconnectWorksheets(); unset($objPHPExcel);
    // Start Bucle Here
    3.- I get 100 rows from database.
    4.- Open again the desired file.
    5.- Write the 100 rows iterating them and using the method fromArray and the exact Column and Row (I'm keeping track of this).
    6.- Write and Close the file.
    7.- Go back to step 3 and repeat until there are no more rows in database.
     */

    private function createPhpExcelObject()
    {
        $this->objPHPExcel = new PHPExcel();
        $this->objPHPExcel->setActiveSheetIndex(0);
    }
}