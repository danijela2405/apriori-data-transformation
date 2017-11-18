<?php
namespace Import;

use PHPExcel_IOFactory;

class ImportCsv
{

    public function importCsvFileIntoDb ()
    {
        $inputFileName = __DIR__.'/../Resources/alarms.csv';
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        var_dump($objPHPExcel->getActiveSheet()->getCell('A1'));
    }
}