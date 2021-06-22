<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 03.12.2019
 * Time: 12:05
 */

namespace frontend\classes\consts;

class ExcelConst
{

    const FILE_NAME = 'export.xlsx';
    const FILE_PATH = '@app/web/uploads/';
    const ROW_BEGIN_KEY = 4;
    const KEY_ORDER = 'A';
    const KEY_NAME = 'B';
    const CATALOG_CODE = 'C';
    const KEY_CODE = 'D';
    const KEY_COUNT = 'E';
    const KEY_PRICE = 'F';

    const KEY_FUEL_RATE = "G";
    const KEY_FUEL_VALUE = 'H';

    const KEY_DELIVER_SUM = "I";
    const KEY_VAT_RATE =  "J";
    const KEY_VAT_VALUE = "K";
    const KEY_DELIVER_WITH_RATE = "L";

    const EMP_NAME = 'B';
    const EMP_MEASURE = 'C';
    const EMP_COUNT = 'D';


    const ACT_NAME = 'B';
    const ACT_CODE = 'C';
    const ACT_COUNT = 'D';
    const ACT_PRICE = 'E';
    const ACT_DELIVER_SUM = "F";
    const ACT_VAT_RATE =  "G";
    const ACT_VAT_VALUE = "H";
    const ACT_DELIVER_WITH_RATE = "I";




}