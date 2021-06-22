<?php
namespace common\components\services;

use Yii;
use yii\httpclient\Client;


class Facturas
{
    const LOGIN = 'onlinefactura';
    const PASSWORD = 'n;xw3CE(GDb$@|D*';

    const BASE_URL = 'https://factura.yt.uz';

    const GET_PROVIDER_BINDING = '/provider/api/uz/register/providerbinding/';
    const PROVIDER_BINDING = '/provider/api/uz/register/providerbinding';
    const BANK_LIST = '/provider/api/uz/catalogs/bank';
    const BANK_VIEW = '/provider/api/uz/catalogs/bank/';
    const MEASURE_LIST = '/provider/api/uz/catalogs/measure';
    const MEASURE_VIEW = '/provider/api/uz/catalogs/measure/';
    const REGION_LIST = '/provider/api/uz/catalogs/region';
    const REGION_VIEW = '/provider/api/uz/catalogs/region/';
    const DISTRICT_LIST = '/provider/api/uz/catalogs/district';
    const DISTRICT_VIEW = '/provider/api/uz/catalogs/district/';

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

    public static function GetGuid() {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::GET_GUID)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerFacturaCancel($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_FACTURA_CANCEL))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerFacturaSend($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_FACTURA_SEND))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerFacturaList($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_FACTURA_LIST))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerFacturaById($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_FACTURA_BY_ID.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function SellerSignedFile($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::SELLER_SIGNED_FILE.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerFacturaAnswer($tin,$data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_FACTURA_ANSWER))
            ->addHeaders(self::getAuth())
            ->setData($data)
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerFacturaList($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_FACTURA_LIST))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerFacturaById($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_FACTURA_BY_ID.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function BuyerSignedFile($tin,$facturaId) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.str_replace("{tin}",$tin,self::BUYER_SIGNED_FILE.$facturaId))
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function GetDistrictView($id) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::DISTRICT_VIEW.$id)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function GetDistrictList() {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::DISTRICT_LIST)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function GetRegionView($id) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::REGION_VIEW.$id)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function GetRegionsList() {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::REGION_LIST)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function GetMeasureView($id) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::MEASURE_VIEW.$id)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function GetMeasureList() {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::MEASURE_LIST)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function GetBankView($id) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::BANK_VIEW.$id)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }

    public static function GetBankList() {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::BANK_LIST)
            ->addHeaders(self::getAuth())
            ->send();
        return $response->isOk ? $response->data : [];
    }


    public static function GetBindProvider($tin) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(self::BASE_URL.self::GET_PROVIDER_BINDING.$tin)
            ->addHeaders(self::getAuth())
            ->send();
         return $response->isOk ? $response->data : [];
    }

    public static function BindProvider($data) {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::BASE_URL.self::PROVIDER_BINDING)
            ->addHeaders(self::getAuth())
            ->setData(['sign' => $data])
            ->send();
        return $response->isOk ? $response->data : [];
    }



    private static function getAuth() {
        return ['Authorization' => 'Basic ' . base64_encode(self::LOGIN.':'.self::PASSWORD)];
    }
}