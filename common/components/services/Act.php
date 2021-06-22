<?php
namespace common\components\services;

use Yii;
use yii\httpclient\Client;


class Act
{
    const LOGIN = 'onlinefactura';
    const PASSWORD = 'n;xw3CE(GDb$@|D*';
    const BASE_URL = 'https://factura.yt.uz';

    const BUYER_SIGNED_FILE = '/provider/api/uz/{tin}/facturas/buyer/signedfile/';
    const BUYER_FACTURA_BY_ID = '/provider/api/uz/{tin}/facturas/buyer/';
    const BUYER_FACTURA_LIST = '/provider/api/uz/{tin}/facturas/buyer';
    const BUYER_FACTURA_ANSWER = '/provider/api/uz/{tin}/facturas/buyer';

    const SELLER_SIGNED_FILE = '/provider/api/uz/{tin}/facturas/seller/signedfile/';
    const SELLER_FACTURA_BY_ID = '/provider/api/uz/{tin}/facturas/seller/';
    const SELLER_FACTURA_LIST = '/provider/api/uz/{tin}/facturas/seller';
    const SELLER_FACTURA_SEND = '/provider/api/uz/{tin}/facturas/seller';
    const SELLER_FACTURA_CANCEL = '/provider/api/uz/{tin}/facturas/seller/cancel';

    const GET_GUID = '/provider/api/uz/utils/guid';




    private static function getAuth() {
        return ['Authorization' => 'Basic ' . base64_encode(self::LOGIN.':'.self::PASSWORD)];
    }
}