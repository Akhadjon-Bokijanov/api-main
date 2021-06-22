<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 03.12.2019
 * Time: 10:36
 */

namespace frontend\classes\viewers;

use PHPExcel_IOFactory;
use PHPExcel_Settings;
use PHPExcel_Shared_Date;
use Yii;

class ExcelViewer
{

    public static function readBySize($filename,$cols,$rows)
    {
        $sheet = static::getExcel($filename,0);

        $col_index = 'A';
        $row_index = 1;

        $data = [];

        for ($i = 0; $i < $rows; $i++){
            $row = [];
            for ($j = 0; $j < $cols; $j++){
                $cord = $col_index . $row_index;
                $row[] = $sheet->getCell($cord)->getValue();
                $col_index++;
            }
            $col_index = 'A';
            $data[] = $row;
            $row_index++;
        }

        return $data;
    }

    public static function readFull($filename)
    {
        $sheet = static::getExcel($filename,0);
//        var_dump($sheet);die;
        $data = [];

        $row_iterator = $sheet->getRowIterator();
        foreach ($row_iterator as $row) {

            $row_data = [];

            $cell_iterator = $row->getCellIterator();
            foreach ($cell_iterator as $cell)
                if(PHPExcel_Shared_Date::isDateTime($cell)) {
                    $row_data[] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getCalculatedValue()));
                } else {
                    $row_data[] = $cell->getCalculatedValue();
                }
            $data[] = $row_data;

        }

        return $data;
    }

    protected static function getExcel($filename,$sheet = false){
        $excel = PHPExcel_IOFactory::load(Yii::getAlias($filename));

        if($sheet === false)
            return $excel;

        $excel->setActiveSheetIndex($sheet);
        return $excel->getActiveSheet();
    }

}