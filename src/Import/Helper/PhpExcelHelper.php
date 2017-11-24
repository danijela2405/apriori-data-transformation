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
     * CSV columns:
     *      A -> time
     *      B ->date
     *      C-> id_camera
     *      D -> camera_position
     *      E-> id_logic_camera
     *      F-> preset_name
     */
    private const TIME_CELL = 'A';
    private const DATE_CELL = 'B';
    private const ID_CAMERA_CELL = 'C';
    private const CAMERA_POSITION_CELL = 'D';
    private const ID_LOGIC_CAMERA_CELL = 'E';
    private const PRESET_NAME_CELL = 'F';

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

    /**
     * @param $currentRowIndex
     * @return Alarm
     */
    public function saveAlarm($currentRowIndex)
    {
        $time = $this->getCellValue(PhpExcelHelper::TIME_CELL, $currentRowIndex);
        $date = $this->getCellValue(PhpExcelHelper::DATE_CELL, $currentRowIndex);
        $idCamera = $this->getCellValue(PhpExcelHelper::ID_CAMERA_CELL, $currentRowIndex);
        $cameraPosition = $this->getCellValue(PhpExcelHelper::CAMERA_POSITION_CELL, $currentRowIndex);
        $idLogicCamera = $this->getCellValue(PhpExcelHelper::ID_LOGIC_CAMERA_CELL, $currentRowIndex);
        $presetName = $this->getCellValue(PhpExcelHelper::PRESET_NAME_CELL, $currentRowIndex);

        return AlarmFactory::setAlarmEntity(
            $time,
            $date,
            $idCamera,
            $cameraPosition,
            $idLogicCamera,
            $presetName
        );
    }

    /**
     * @param $column
     * @param $row
     * @return mixed
     */
    private function getCellValue($column, $row)
    {
        $cell = $this->objPHPExcel->getActiveSheet()->getCell($column.$row);

        return $cell->getValue();
    }
}