<?php

namespace Import\Helper;

use Alarm;
use Import\Factory\AlarmFactory;
use PHPExcel;
use PHPExcel_IOFactory;

/**
 * Class PhpExcelHelper
 * @package Import\Helper
 */
class PhpExcelHelper
{
    /**
     * @var PHPExcel
     */
    private $objPHPExcel;

    /**
     * PhpExcelHelper constructor.
     */
    public function __construct()
    {
        $inputFileName = __DIR__.'/../../Resources/alarms.csv';

        echo "Loading .csv file...\r\n";

        $this->objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

        echo "Finished .loading csv file!\r\n";
    }

    public function getRowCount()
    {
        return $this->objPHPExcel->getActiveSheet()->getHighestDataRow();
    }

    public function getActiveSheet()
    {
        return $this->objPHPExcel->getActiveSheet();
    }
}